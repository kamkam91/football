<?php

declare(strict_types=1);

namespace App\Application\Service\Finder;

interface StatisticFinderInterface
{
    public function getTeamStatistics(string $matchId, string $teamId): array;
    public function getMatchStatistics(string $matchId): array;
}