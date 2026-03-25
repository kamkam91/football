<?php

declare(strict_types=1);

namespace App\Application\Service\Repository;

interface StatisticRepositoryInterface
{
    public function updateTeamStatistics(string $matchId, string $teamId, string $statType, int $value = 1): void;
}