<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        // ...
    }
 
    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'message' => $request->message,
        ], $request->statusCode);
    }
}
