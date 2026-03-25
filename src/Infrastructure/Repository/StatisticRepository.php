<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Service\Repository\StatisticRepositoryInterface;

final readonly class StatisticRepository implements StatisticRepositoryInterface
{
    public function updateTeamStatistics(string $matchId, string $teamId, string $statType, int $value = 1): void
    {
        // TODO: Implement updateTeamStatistics() method.
    }

    public function getAll(): array
    {

    }
}