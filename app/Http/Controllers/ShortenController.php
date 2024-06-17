<?php

namespace App\Http\Controllers;

use App\Requests\ShortRequest;
use App\Requests\UnlockRequest;
use App\Services\ShortenService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Random\RandomException;
use SebastianBergmann\Invoker\TimeoutException;
use SodiumException;

class ShortenController
{
    private ShortenService $shorten_service;
    public function __construct(ShortenService $shorten_service)
    {
        $this->shorten_service = $shorten_service;
    }

    public function short_url(ShortRequest $request) {
        try {
            $shortened_url = $this->shorten_service->shorten($request->url, $request->passphrase);
            $shortened_url->full_url = env("SHORTENED_BASE_URL", request()->getHttpHost())."/".$shortened_url->code;
            return response()->json(["status" => "SUCCESS", "result" => $shortened_url], 201);
        } catch (RandomException $randomException) {
            return response()->json([
                "status" => "RANDOM_ERROR",
                "message" => "Failed to generate random data",
            ], 500);
        } catch (TimeoutException $timeoutException) {
            return response()->json([
                "status" => "UNIQUENESS_ERROR",
                "message" => $timeoutException->getMessage(),
            ], 500);
        } catch (SodiumException $encryptException) {
            return response()->json([
                "status" => "CRYPTO_ERROR",
                "message" => $encryptException->getMessage(),
            ], 500);
        }
    }

    public function retrieve_url(Request $request) {
        $code = $request->code;
        $url_data = $this->shorten_service->retrieve_destination($code);

        if (!$url_data->encrypted) {
            return response()->redirectTo($url_data->destination);
        } else {
            return response()->redirectTo("/#/unlock?code=$code");
        }
    }

    public function unlock(UnlockRequest $request) {
        try {
            $code = $request->code;
            $passphrase = $request->passphrase;
            $unlocked_data = $this->shorten_service->unlock_destination($code, $passphrase);
            $unlocked_data->full_url = env("SHORTENED_BASE_URL", request()->getHttpHost())."/".$unlocked_data->code;
        } catch (DecryptException $decryptException) {
            return response()->json([
                "status" => "CRYPTO_ERROR",
                "message" => "Invalid password"
            ], 403);
        } catch (SodiumException $encryptException) {
            return response()->json([
                "status" => "CRYPTO_ERROR",
                "message" => $encryptException->getMessage()
            ], 500);
        }

        return response()->json(["status" => "SUCCESS", "result" => $unlocked_data]);
    }
}
