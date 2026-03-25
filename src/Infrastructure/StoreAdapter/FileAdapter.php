<?php

declare(strict_types=1);

namespace App\Infrastructure\StoreAdapter;

class FileAdapter implements StoreAdapterInterface
{
    private $file;

    public function __construct(array $configuration = [])
    {
        $this->file = $configuration['file'];

        $directory = dirname($this->file);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function getAll(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $content = file_get_contents($this->file);
        return json_decode($content, true) ?? [];
    }

    public function save()
    {

    }
}