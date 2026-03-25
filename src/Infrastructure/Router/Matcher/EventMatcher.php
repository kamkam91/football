<?php

declare(strict_types=1);

namespace App\Infrastructure\Router\Matcher;

use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use App\UI\Rest\AddEvent;

final readonly class EventMatcher implements RouterMatcherInterface
{
    public function isEligible(string $method, string $path): bool
    {
        return $method === 'POST' && $path === '/event';
    }

    public function processRequest(mixed $payload): ResponseInterface
    {
        $data = json_decode($payload, true, 512, JSON_ERROR_NONE);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return JsonResponse::Error(['error' => 'Invalid JSON']);
        }

        if (!isset($data['type'])) {
            return JsonResponse::Error(['error' => 'Event type is required']);
        }

        return new AddEvent()->__invoke($data);
    }
}
