<?php

namespace App\Services;

use App\Models\ShortenedUrl;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laminas\Escaper\Exception\RuntimeException;
use Random\RandomException;
use SebastianBergmann\Invoker\TimeoutException;
use SodiumException;

define("MEMORY_COST", 65536);
define("TIME_COST", 4);
define("HASH_LENGTH", 32);


class ShortenService
{
    /**
     * @throws RandomException
     */
    private function generate_code(int $length = 5): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function is_code_unique(string $code): bool {
        return ShortenedUrl::query()->where('code', $code)->count() === 0;
    }

    /**
     * @throws RandomException
     */
    private function generate_unique_url(int $length = 5): string {
        $codes = Array();
        for ($i = 0; $i < 5; $i++) {
            $codes[$i] = $this->generate_code($length);
        }

        $tries = 0;
        while ($tries < 250) {
            foreach ($codes as $code) {
                if ($this->is_code_unique($code)) { return $code; }
            }

            $tries++;
        }

        throw new TimeoutException('Max uniqueness tries reached');
    }

    /**
     * @throws RandomException
     * @throws SodiumException
     */
    private function encrypt_url(string $url, string $passphrase): string {
        $method = "aes-256-cbc";

        $salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
        $hash = sodium_crypto_pwhash(
            HASH_LENGTH,
            $passphrase,
            $salt,
            TIME_COST,
            MEMORY_COST,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $iv = random_bytes(openssl_cipher_iv_length($method));
        $encrypted_bytes = openssl_encrypt(
            $url,
            $method,
            $hash,
            OPENSSL_RAW_DATA,
            $iv
        );

        if (!$encrypted_bytes) {
            throw new EncryptException("Failed to encrypt URL");
        }

        return base64_encode($salt . $iv . $encrypted_bytes);
    }

    /**
     * @throws SodiumException
     */
    private function decrypt_url(string $encrypted_url, string $passphrase): string {
        $method = "aes-256-cbc";
        $iv_length = openssl_cipher_iv_length($method);
        $bytes = base64_decode($encrypted_url);

        $salt = mb_substr($bytes, 0, SODIUM_CRYPTO_PWHASH_SALTBYTES, '8bit');
        $iv = mb_substr($bytes, SODIUM_CRYPTO_PWHASH_SALTBYTES, $iv_length, '8bit');
        $data = mb_substr($bytes, SODIUM_CRYPTO_PWHASH_SALTBYTES + $iv_length, null, '8bit');

        $hash = sodium_crypto_pwhash(
            HASH_LENGTH,
            $passphrase,
            $salt,
            TIME_COST,
            MEMORY_COST,
            SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
        );

        $decrypted_url = openssl_decrypt($data, $method, $hash, OPENSSL_RAW_DATA, $iv);
        if (!$decrypted_url) {
            throw new DecryptException("Failed to decrypt URL");
        }

        return $decrypted_url;
    }

    public function retrieve_destination(string $code)
    {
        $url = ShortenedUrl::query()->where('code', $code)->first();

        if (!$url) {
            throw new HttpResponseException(
                response()->json([
                    "status" => "NOT_FOUND",
                    "message" => "Could not find a URL with code $code"
                ], 404));
        }
        if ($url->encrypted) {unset($url->destination);}

        return $url;
    }

    /**
     * @throws SodiumException
     */
    public function unlock_destination(string $code, string $passphrase) {
        $url = ShortenedUrl::query()->where('code', $code)->first();

        if (!$url) {throw new HttpResponseException(
            response()->json([
                "status" => "NOT_FOUND",
                "message" => "Could not find a URL with code $code"
            ], 404));
        }

        $url->destination = $this->decrypt_url($url->destination, $passphrase);
        return $url;
    }

    /**
     * @throws RandomException|SodiumException
     */
    public function shorten(string $url, string $passphrase = null) {
        $shortened_url = $this->generate_unique_url();
        $encrypted = $passphrase != null;
        $destination = !$encrypted ? $url : $this->encrypt_url(
            $url,
            $passphrase
        );

        $url_model = ShortenedUrl::create([
            'code' => $shortened_url,
            'destination' => $destination,
            'encrypted' => $encrypted
        ]);

        if ($encrypted) {
            unset($url_model->destination);
        }

        return $url_model;
    }
}
