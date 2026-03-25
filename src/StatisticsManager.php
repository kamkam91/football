<?php

declare(strict_types=1);

namespace App;

//TODO: Move the logic from this class to the Repository class. The Manager name is not appropriate for any class
class StatisticsManager
{

    public function __construct(private string $statsFile = '../storage/statistics.txt')
    {
        $directory = dirname($this->statsFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        if (false === file_exists($this->statsFile)) {
            file_put_contents($this->statsFile, '');
        }
    }
    
    public function updateTeamStatistics(string $matchId, string $teamId, string $statType, int $value = 1): void
    {
        $stats = $this->getStatistic();
        
        if (!isset($stats[$matchId])) {
            $stats[$matchId] = [];
        }
        
        if (!isset($stats[$matchId][$teamId])) {
            $stats[$matchId][$teamId] = [];
        }
        
        if (!isset($stats[$matchId][$teamId][$statType])) {
            $stats[$matchId][$teamId][$statType] = 0;
        }
        
        $stats[$matchId][$teamId][$statType] += $value;
        
        $this->saveStatistics($stats);
    }

    private function getStatistic(): array
    {
        return json_decode(file_get_contents($this->statsFile), true) ?? [];
    }
    
    private function saveStatistics(array $stats): void
    {
        file_put_contents($this->statsFile, json_encode($stats, JSON_PRETTY_PRINT), LOCK_EX);
    }
}
