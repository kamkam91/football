<?php

declare(strict_types=1);

namespace App\Infrastructure\Router;

use App\Infrastructure\Router\Matcher\RouterMatcherInterface;

final readonly class RouterResolver
{
    /**
     * @param iterable|RouterMatcherInterface[] $routes
     */
    public function __construct(private iterable $routes)
    {
    }

    public function resolve(string $method, string $path): ResponseInterface
    {
        foreach ($this->routes as $matcher) {
            if (false === $matcher->isEligible(method: $method, path: $path)) {
                continue;
            }

            return $matcher->processRequest(file_get_contents('php://input'));
        }

        return JsonResponse::NotFound(json_encode(['error' => 'Not found']));
    }
}
