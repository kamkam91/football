<?php

declare(strict_types=1);

namespace App\Application\Model\Event;

abstract class Details
{

    public function __construct(
        public readonly EventTypeEnum $type,
        public readonly null|string $teamId,
        public readonly null|string $matchId,
    ) {
    }

    abstract static function createFromArray(EventTypeEnum $eventTypeEnum, array $data): self;

    public function toArray(): array
    {
        $fields = get_object_vars($this);
        unset($fields['type']);

        return $fields;
    }
}