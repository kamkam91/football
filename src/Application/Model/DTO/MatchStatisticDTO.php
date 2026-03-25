<?php

declare(strict_types=1);

namespace App\Application\Model\DTO;

class MatchStatisticDTO
{
    public function __construct(
        public string $matchId,
        public null|string $teamId,
        public array $statistics
    ) {
    }

    public function toArray(): array
    {
        $result = [
            'match_id' => $this->matchId,
            'statistics' => $this->statistics
        ];

        if (null !== $this->teamId) {
            $result['team_id'] = $this->teamId;
        }

        return $result;
    }
}