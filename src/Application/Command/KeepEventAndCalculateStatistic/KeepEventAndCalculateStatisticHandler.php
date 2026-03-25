<?php

declare(strict_types=1);

namespace App\Application\Command\KeepEventAndCalculateStatistic;

use App\EventHandler;

class KeepEventAndCalculateStatisticHandler
{
    public function __invoke(KeepEventAndCalculateStatisticMessage $message)
    {
        // TODO: Escape logic form handler, inject repository class for save event and push event to update statistic
        $handler = new EventHandler(__DIR__ . '/../../../storage/events.txt');
        $handler->handleEvent($message->event);
    }
}