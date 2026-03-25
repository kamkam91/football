<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Application\Model\Event\Event;

final readonly class KeepEventAndCalculateStatisticMessage
{
    public function __construct(public Event $event)
    {
    }
}