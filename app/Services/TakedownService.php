<?php

namespace App\Services;

use App\Models\ShortenedUrl;
use App\Models\TakedownRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TakedownService
{
    public function store_request(string $code, string $reason, string $password = null) {
        $url = ShortenedUrl::query()->where("code", $code)->first();
        if (!$url) {throw new HttpResponseException(
            response()->json([
                "status" => "NOT_FOUND",
                "message" => "Could not find a URL with code $code"
            ], 404));
        }

        $request = TakedownRequest::create([
            'url_id' => $url->id,
            'password' => $password,
            'reason' => $reason,
        ]);

        unset($request->password);

        return $request;
    }

    public function list_requests() {
        return TakedownRequest::query()
            ->select(["shorten_urls.code as url_id", "status", "reason"])
            ->join("shorten_urls", "shorten_urls.id", "=", "takedown_requests.url_id")
            ->get();
    }
}
