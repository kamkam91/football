<?php

declare(strict_types=1);

namespace App\Infrastructure\StoreAdapter;

interface StoreAdapterInterface
{
    public function getAll(): array;

    public function save(array $data): void;
}