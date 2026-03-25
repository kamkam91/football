<?php

declare(strict_types=1);

namespace App\Application\Query\GetMatchStatistic;

final readonly class MatchStatisticQueryMessage
{
    public function __construct(public string $matchId, public null|string $teamId)
    {
    }
}
