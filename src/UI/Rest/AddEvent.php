<?php

declare(strict_types=1);

namespace App\UI\Rest;

use App\Application\Command\KeepEventAndCalculateStatisticHandler;
use App\Application\Command\KeepEventAndCalculateStatisticMessage;
use App\Application\Model\Event\Event;
use App\Application\Model\Event\EventTypeEnum;
use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use Exception;

final readonly class AddEvent
{
    public function __invoke(array $payload): ResponseInterface
    {
        try {
            // TODO: Add validator for payload
            $type = EventTypeEnum::from($payload['type']);
            $event = new Event($type, $payload);
            new KeepEventAndCalculateStatisticHandler()->__invoke(new KeepEventAndCalculateStatisticMessage($event));

            return JsonResponse::Created([
                'status' => 'success',
                'message' => 'Event saved successfully',
                'event' => $event->toArray()
            ]);
        } catch (\InvalidArgumentException $e) {
            return JsonResponse::Error(['error' => $e->getMessage()]);
        } catch (Exception) {
            // TODO: Add error log to graylog or monolog
            return JsonResponse::Error(['error' => 'Error while adding event']);
        }
    }
}
