<?php

declare(strict_types=1);

namespace App\UI\Rest;

use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use App\StatisticsManager;
use Exception;

final readonly class GetStatistics
{
    public function __invoke(string $matchId, null|string $teamId): ResponseInterface
    {
        try {
            $statsManager = new StatisticsManager(__DIR__ . '/../../../storage/statistics.txt');
            if (null !== $teamId) {
                $response = [
                    'match_id' => $matchId,
                    'team_id' => $teamId,
                    'statistics' => $statsManager->getTeamStatistics($matchId, $teamId)
                ];
            } else {
                $response = [
                    'match_id' => $matchId,
                    'statistics' => $statsManager->getMatchStatistics($matchId)
                ];
            }
        } catch (Exception) {
            // TODO: Add error log to graylog or monolog
            return JsonResponse::InternalError(['error' => 'Error while fetching statistics.']);
        }

        return JsonResponse::OK($response);
    }
}