<?php

declare(strict_types=1);

namespace App\UI\Rest;

use App\EventHandler;
use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use Exception;

final readonly class AddEvent
{
    public function __invoke(array $payload): ResponseInterface
    {
        try {
            $handler = new EventHandler(__DIR__ . '/../../../storage/events.txt');
            $result = $handler->handleEvent($payload);

            return JsonResponse::Created($result);
        } catch (\InvalidArgumentException $e) {
            return JsonResponse::Error(['error' => $e->getMessage()]);
        } catch (Exception) {
            // TODO: Add error log to graylog or monolog
            return JsonResponse::Error(['error' => 'Error while adding event']);
        }
    }
}