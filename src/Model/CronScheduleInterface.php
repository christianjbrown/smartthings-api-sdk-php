<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CronScheduleInterface
{
    public function getExpression(): string;

    public function getTimezone(): string;
}
