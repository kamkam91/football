<?php

namespace Tests;

use App\Application\Model\Event\Event;
use App\Application\Model\Event\EventTypeEnum;
use App\EventHandler;
use App\FileStorage;
use App\Infrastructure\Finder\StatisticFinder;
use App\StatisticsManager;
use PHPUnit\Framework\TestCase;

class EventHandlerTest extends TestCase
{
    private string $testFile;
    private string $testStatsFile;
    
    protected function setUp(): void
    {
        $this->testFile = sys_get_temp_dir() . '/test_events_' . uniqid() . '.txt';
        $this->testStatsFile = sys_get_temp_dir() . '/test_stats_' . uniqid() . '.txt';
    }
    
    protected function tearDown(): void
    {
        if (file_exists($this->testFile)) {
            unlink($this->testFile);
        }
        if (file_exists($this->testStatsFile)) {
            unlink($this->testStatsFile);
        }
    }
    
    public function testHandleGoalEvent(): void
    {
        $handler = new EventHandler($this->testFile);

        $eventData = new Event(EventTypeEnum::GOAL, [
            'type' => 'goal',
            'player' => 'John Doe',
            'minute' => 23,
            'second' => 34
        ]);
        
        $result = $handler->handleEvent($eventData);
        
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('goal', $result['event']['type']);
        $this->assertArrayHasKey('timestamp', $result['event']);
    }
    

    public function testEventIsSavedToFile(): void
    {
        $storage = new FileStorage($this->testFile);
        $handler = new EventHandler($this->testFile);
        $eventData = new Event(EventTypeEnum::GOAL, [
            'type' => 'goal',
            'player' => 'Jane Smith'
        ]);

        $handler->handleEvent($eventData);

        $this->assertFileExists($this->testFile);
        $savedEvents = $storage->getAll();
        $this->assertCount(1, $savedEvents);
        $this->assertEquals('goal', $savedEvents[0]['type']);
    }

    public function testHandleFoulEventUpdatesStatistics(): void
    {
        $statisticsManager = new StatisticsManager($this->testStatsFile);
        $statisticsFinder = new StatisticFinder($this->testStatsFile);
        $handler = new EventHandler($this->testFile, $statisticsManager);

        $eventData = new Event(EventTypeEnum::FOUL, [
            'type' => 'foul',
            'player' => 'William Saliba',
            'team_id' => 'arsenal',
            'match_id' => 'm1',
            'minute' => 45,
            'second' => 34
        ]);

        $result = $handler->handleEvent($eventData);

        // Check that event was saved successfully
        $this->assertEquals('success', $result['status']);
        $this->assertEquals('foul', $result['event']['type']);

        // Check that statistics were updated
        $teamStats = $statisticsFinder->getTeamStatistics('m1', 'arsenal');
        $this->assertArrayHasKey('fouls', $teamStats);
        $this->assertEquals(1, $teamStats['fouls']);
    }

    public function testHandleMultipleFoulEventsIncrementsStatistics(): void
    {
        $statisticsManager = new StatisticsManager($this->testStatsFile);
        $statisticsFinder = new StatisticFinder($this->testStatsFile);
        $handler = new EventHandler($this->testFile, $statisticsManager);

        $eventData1 = new Event(EventTypeEnum::FOUL, [
            'type' => 'foul',
            'player' => 'John Doe',
            'team_id' => 'team_a',
            'match_id' => 'match_1',
            'minute' => 15,
            'second' => 34
        ]);
        $eventData2 = new Event(EventTypeEnum::FOUL, [
            'type' => 'foul',
            'player' => 'Jane Smith',
            'team_id' => 'team_a',
            'match_id' => 'match_1',
            'minute' => 30,
            'second' => 34
        ]);

        $handler->handleEvent($eventData1);
        $handler->handleEvent($eventData2);

        // Check that statistics were incremented correctly
        $teamStats = $statisticsFinder->getTeamStatistics('match_1', 'team_a');
        $this->assertEquals(2, $teamStats['fouls']);
    }

    public function testHandleFoulEventWithoutRequiredFields(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('match_id and team_id are required for foul events');

        $statisticsManager = new StatisticsManager($this->testStatsFile);
        $handler = new EventHandler($this->testFile, $statisticsManager);

        $eventData = new Event(EventTypeEnum::FOUL, [
            'type' => 'foul',
            'player' => 'John Doe',
            'minute' => 45,
            'second' => 34
            // Missing match_id and team_id
        ]);

        $handler->handleEvent($eventData);
    }
}