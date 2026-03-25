<?php

declare(strict_types=1);

namespace App\UI\Rest;

use App\Application\Query\GetMatchStatistic\MatchStatisticHandler;
use App\Application\Query\GetMatchStatistic\MatchStatisticQueryMessage;
use App\Infrastructure\Finder\StatisticFinder;
use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use App\StatisticsManager;
use Exception;

final readonly class GetStatistics
{
    public function __invoke(string $matchId, null|string $teamId): ResponseInterface
    {
        try {
            $response = new MatchStatisticHandler(new StatisticFinder())->__invoke(new MatchStatisticQueryMessage($matchId, $teamId));

        } catch (Exception) {
            // TODO: Add error log to graylog or monolog
            return JsonResponse::InternalError(['error' => 'Error while fetching statistics.']);
        }

        return JsonResponse::OK($response->toArray());
    }
}
