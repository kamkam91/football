<?php

namespace App;

use App\Application\Model\Event\Event;
use App\Application\Model\Event\EventTypeEnum;

class EventHandler
{
    private FileStorage $storage;
    private StatisticsManager $statisticsManager;
    
    public function __construct(string $storagePath, ?StatisticsManager $statisticsManager = null)
    {
        $this->storage = new FileStorage($storagePath);
        $this->statisticsManager = $statisticsManager ?? new StatisticsManager(__DIR__ . '/../storage/statistics.txt');
    }
    
    public function handleEvent(Event $event): array
    {

        $this->storage->save($event->toArray());

        // Update statistics for foul events
        if ($event->type === EventTypeEnum::FOUL) {
            if (null === $event->data->matchId || null === $event->data->teamId) {
                throw new \InvalidArgumentException('match_id and team_id are required for foul events');
            }
            
            $this->statisticsManager->updateTeamStatistics(
                $event->data->matchId,
                $event->data->teamId,
                $event->type->getStatisticType()
            );
        }
        
        return [
            'status' => 'success',
            'message' => 'Event saved successfully',
            'event' => $event->toArray()
        ];
    }
}