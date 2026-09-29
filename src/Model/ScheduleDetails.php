<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ScheduleDetails implements ScheduleDetailsInterface
{
    private ?CronScheduleInterface $cron = null;

    public function getCron(): ?CronScheduleInterface
    {
        return $this->cron;
    }

    public function setCron(?CronScheduleInterface $value): ScheduleDetailsInterface
    {
        $this->cron = $value;

        return $this;
    }
}
