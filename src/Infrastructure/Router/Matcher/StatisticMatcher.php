<?php

declare(strict_types=1);

namespace App\Infrastructure\Router\Matcher;

use App\Infrastructure\Router\JsonResponse;
use App\Infrastructure\Router\ResponseInterface;
use App\UI\Rest\GetStatistics;

final readonly class StatisticMatcher implements RouterMatcherInterface
{
    public function isEligible(string $method, string $path): bool
    {
        return $method === 'GET' && $path === '/statistics';
    }

    public function processRequest(mixed $payload): ResponseInterface
    {
        if (null === $matchId = $_GET['match_id'] ?? null) {
            return JsonResponse::Error(['error' => 'match_id is required']);
        }

        return new GetStatistics()->__invoke(
            matchId: $matchId,
            teamId: $_GET['team_id'] ?? null
        );
    }
}
