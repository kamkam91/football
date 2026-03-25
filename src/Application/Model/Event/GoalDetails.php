<?php

declare(strict_types=1);

namespace App\Application\Model\Event;

final class GoalDetails extends Details
{
    public function __construct(
        public string $scorer,
        EventTypeEnum $eventType,
        public null|string $assistingPlayer,
        public readonly null|int $minute,
        null|string $teamId,
        null|string $matchId,
    )
    {
        parent::__construct($eventType, $teamId, $matchId);
    }

    static function createFromArray(EventTypeEnum $eventTypeEnum, array $data): Details
    {
        return new self(
            scorer: $data['player'],
            eventType: $eventTypeEnum,
            assistingPlayer: $data['assistant'] ?? null,
            minute: $data['minute'] ?? null,
            teamId: $data['team_id'] ?? null,
            matchId: $data['match_id']?? null,
        );
    }
}