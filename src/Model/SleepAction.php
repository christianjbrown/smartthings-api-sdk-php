<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SleepAction implements SleepActionInterface
{
    private IntervalInterface $duration;

    public function __construct(IntervalInterface $duration)
    {
        $this->duration = $duration;
    }

    public function getDuration(): IntervalInterface
    {
        return $this->duration;
    }
}
