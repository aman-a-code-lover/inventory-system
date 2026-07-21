<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Quick test endpoint.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'message' => 'Test controller reachable',
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
}
