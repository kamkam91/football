<?php

declare(strict_types=1);

namespace App\Application\Model\Event;

final class FoulDetails extends Details
{
    public function __construct(
        public readonly string $fouling,
        public readonly int $minute,
        public readonly int $second,
        EventTypeEnum $type,
        public readonly null|string $affectedPlayer,
        null|string $teamId,
        null|string $matchId
    )
    {
        parent::__construct($type, $teamId, $matchId);
    }

    static function createFromArray(EventTypeEnum $eventTypeEnum, array $data): Details
    {
        return new self(
            fouling: $data['player'],
            minute: $data['minute'],
            second: $data['second'],
            type: $eventTypeEnum,
            affectedPlayer: $data['affected_player'] ?? null,
            teamId: $data['team_id'] ?? null,
            matchId: $data['match_id'] ?? null,
        );
    }
}