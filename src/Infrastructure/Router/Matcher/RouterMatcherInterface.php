<?php

declare(strict_types=1);

namespace App\Infrastructure\Router\Matcher;

use App\Infrastructure\Router\ResponseInterface;

interface RouterMatcherInterface
{
    public function isEligible(string $method, string $path): bool;

    public function processRequest(mixed $payload): ResponseInterface;
}