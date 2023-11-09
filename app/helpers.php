<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

if (!function_exists('okResponse')) {
    function okResponse(array $result, int $status = ResponseAlias::HTTP_OK, ?string $errorMessage = null, array $headers = []): JsonResponse
    {
        return response()->json(['data' => $result, 'error' => $errorMessage], $status, $headers);
    }
}
if (!function_exists('errResponse')) {
    function errResponse(string $errorMessage, int $status = ResponseAlias::HTTP_INTERNAL_SERVER_ERROR, array $headers = []): JsonResponse
    {
        return response()->json(['data' => [], 'error' => $errorMessage], $status, $headers);
    }
}
