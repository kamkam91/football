<?php

declare(strict_types=1);

namespace App\Infrastructure\Router;

class JsonResponse implements ResponseInterface
{
    private function __construct(
        public int $statusCode,
        public string $body
    ) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
    }

    public static function OK(array $body)
    {
        return new self(200, json_encode($body));
    }

    public static function Created(array $body)
    {
        return new self(201, json_encode($body));
    }

    public static function Error(array $body)
    {
        return new self(400, json_encode($body));
    }

    public static function InternalError(array $body)
    {
        return new self(500, json_encode($body));
    }

    public static function NotFound(string $body)
    {
        return new self(404, $body);
    }
}