<?php

declare(strict_types=1);

namespace App\Application\Query\GetMatchStatistic;

use App\Application\Model\DTO\MatchStatisticDTO;
use App\Application\Service\Finder\StatisticFinderInterface;
use App\Application\Service\Repository\StatisticRepositoryInterface;

final readonly class MatchStatisticHandler
{
    public function __construct(private StatisticFinderInterface $statisticFinder)
    {
    }

    public function __invoke(MatchStatisticQueryMessage $message): MatchStatisticDTO
    {
        $statistics = match ($message->teamId) {
            null => $this->statisticFinder->getMatchStatistics($message->matchId),
            default => $this->statisticFinder->getTeamStatistics($message->matchId, $message->teamId),
        };

        return new MatchStatisticDTO($message->matchId, $message->teamId, $statistics);
    }
}