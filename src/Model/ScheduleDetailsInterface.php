<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ScheduleDetailsInterface
{
    public function getCron(): ?CronScheduleInterface;

    public function setCron(?CronScheduleInterface $value): self;
}
