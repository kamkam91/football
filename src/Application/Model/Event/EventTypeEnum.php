<?php

declare(strict_types=1);

namespace App\Application\Model\Event;

enum EventTypeEnum: string
{
    case GOAL = 'goal';
    case FOUL = 'foul';

    public function getObject(array $data): Details
    {
        return match($this) {
            self::GOAL => GoalDetails::createFromArray($this, $data),
            self::FOUL => FoulDetails::createFromArray($this, $data),
        };
    }

    public function getStatisticType(): string
    {
        return match($this) {
            self::FOUL => 'fouls',
            self::GOAL => 'goals',
        };
    }
}
