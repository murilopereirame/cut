<?php

namespace App\Http\Controllers;

use App\Requests\ShortRequest;
use App\Services\ShortenService;
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
            return response()->json(["status" => "SUCCESS", "result" => $shortened_url], 201);
        } catch (RandomException $randomException) {
            return response()->json([
                "status" => "RANDOM_ERROR",
                "message" => "Failed to generate random data",
                "details" => $randomException->getTraceAsString()
            ]);
        } catch (TimeoutException $timeoutException) {
            return response()->json([
                "status" => "UNIQUENESS_ERROR",
                "message" => $timeoutException->getMessage(),
                "details" => $timeoutException->getTraceAsString()
            ]);
        } catch (SodiumException $encryptException) {
            return response()->json([
                "status" => "CRYPTO_ERROR",
                "message" => $encryptException->getMessage(),
                "details" => $encryptException->getTraceAsString()
            ]);
        }
    }
}
