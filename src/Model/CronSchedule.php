<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CronSchedule implements CronScheduleInterface
{
    private string $expression;
    private string $timezone;

    public function __construct(string $expression, string $timezone)
    {
        $this->expression = $expression;
        $this->timezone = $timezone;
    }

    public function getExpression(): string
    {
        return $this->expression;
    }

    public function getTimezone(): string
    {
        return $this->timezone;
    }
}
