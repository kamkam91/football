<?php

declare(strict_types=1);

namespace App\Infrastructure\Finder;

use App\Application\Service\Finder\StatisticFinderInterface;
use App\Infrastructure\StoreAdapter\FileAdapter;
use App\Infrastructure\StoreAdapter\StoreAdapterInterface;

class StatisticFinder implements StatisticFinderInterface
{
    private StoreAdapterInterface $adapter;

    public function __construct(string $statsFile = __DIR__ . '/../../../storage/statistics.txt')
    {
        $this->adapter = new FileAdapter(['file' => $statsFile]);
    }

    public function getTeamStatistics(string $matchId, string $teamId): array
    {
        $stats = $this->adapter->getAll();

        return $stats[$matchId][$teamId] ?? [];
    }

    public function getMatchStatistics(string $matchId): array
    {
        $stats = $this->adapter->getAll();

        return $stats[$matchId] ?? [];
    }
}