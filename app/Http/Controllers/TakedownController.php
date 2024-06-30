<?php

namespace App\Http\Controllers;

use App\Requests\TakedownRequest;
use App\Services\TakedownService;
use Illuminate\Support\Facades\Request;

class TakedownController
{
    private TakedownService $takedownService;
    public function __construct(TakedownService $takedownService) {
        $this->takedownService = $takedownService;
    }

    public function create(TakedownRequest $request) {
        $created_request = $this->takedownService->store_request($request->code, $request->reason, $request->password ?? null);
        return response()->json([
            "status" => "SUCCESS",
            "result" => $created_request
        ], 201);
    }

    public function list(Request $request) {
        $takedown_requests = $this->takedownService->list_requests();
        return response()->json([
            "status" => "SUCCESS",
            "result" => $takedown_requests
        ]);
    }
}
