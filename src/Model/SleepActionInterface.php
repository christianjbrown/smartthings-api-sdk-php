<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SleepActionInterface
{
    public function getDuration(): IntervalInterface;
}
