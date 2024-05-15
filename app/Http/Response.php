<?php

namespace App\Http;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class Response implements Responsable
{

    public function __construct(
        protected array $content = [],
        protected       $message = '',
        protected int   $status = 200,
        protected array $headers = []
    )
    {
    }

    public static function ok(array $content = [], string $message = 'OK', int $status = 200, array $headers = []): static
    {
        return new static($content, $message, $status, $headers);
    }

    public static function error(array $content = [], string $message = "ERROR", int $status = 400, array $headers = []): static
    {
        return new static($content, $message, $status, $headers);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'message' => $this->message,
            'data' => count($this->content) > 0 ? $this->content : null,
        ], $this->status, $this->headers);
    }
}
