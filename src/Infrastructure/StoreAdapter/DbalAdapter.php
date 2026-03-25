<?php

declare(strict_types=1);

namespace App\Infrastructure\StoreAdapter;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbalAdapter implements StoreAdapterInterface
{
    private string $table;
    private array $columns = [];

    public function __construct(array $params)
    {
        $this->table = $params['table'];
        $this->columns = $params['columns'];
    }

    private function getConnection(): Connection
    {
        $connectionParams = [
            'dbname' => 'football_events_app',
            'user' => 'user',
            'password' => 'asdsad89a6d87A*(S7d987a09',
            'host' => 'db',
            'driver' => 'pdo_mysql',
        ];
        return DriverManager::getConnection($connectionParams);
    }

    public function getAll(): array
    {
        return $this->getConnection()
            ->createQueryBuilder()
            ->from($this->table)
            ->select($this->columns)
            ->setMaxResults(10)
            ->executeQuery()
            ->fetchAssociative();
    }

    public function save(array $data): void
    {
        // TODO: Implement save() method.
    }
}