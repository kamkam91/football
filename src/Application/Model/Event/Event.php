<?php

declare(strict_types=1);

namespace App\Application\Model\Event;

use DateTimeImmutable;

final readonly class Event
{
    public DateTimeImmutable $createdAt;
    public Details $data;

    public function __construct(
        public EventTypeEnum $type,
        array $eventData,
    ) {
        $this->data = $type->getObject($eventData);
        $this->createdAt = new DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type->value,
            'timestamp' => $this->createdAt->getTimestamp(),
            'data' => $this->data->toArray(),
        ];
    }
}