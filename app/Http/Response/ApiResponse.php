<?php
declare(strict_types=1);

namespace App\Http\Response;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class ApiResponse extends JsonResponse
{
    public static function success($response = [], array $meta = []): self
    {
        return new static([
            'data' => $response,
            'meta' => $meta,
        ]);
    }

    public static function empty(): self
    {
        return new static(null, Response::HTTP_NO_CONTENT);
    }

    public static function created(): self
    {
        return new static(null, Response::HTTP_CREATED);
    }
}
