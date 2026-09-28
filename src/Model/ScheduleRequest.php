<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ScheduleRequest implements ScheduleRequestInterface
{
    private ?CronScheduleInterface $cron = null;
    private string $name;
    private ?OnceScheduleInterface $once = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getCron(): ?CronScheduleInterface
    {
        return $this->cron;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOnce(): ?OnceScheduleInterface
    {
        return $this->once;
    }

    public function setCron(?CronScheduleInterface $value): ScheduleRequestInterface
    {
        $this->cron = $value;

        return $this;
    }

    public function setOnce(?OnceScheduleInterface $value): ScheduleRequestInterface
    {
        $this->once = $value;

        return $this;
    }
}
