<?php

namespace App\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class Response implements Responsable
{

    public function __construct(
        protected array $content = [],
        protected int    $status = 200,
        protected array  $headers = []
    )
    {
    }

    public static function ok(array $content = [],  int $status = 200, array $headers = []): static
    {
        return new static($content, $status, $headers);
    }

    public static function error(array $content = [],  int $status = 400, array $headers = []): static
    {
        return new static($content, $status, $headers);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'data' => $this->content
        ], $this->status, $this->headers);
    }
}
