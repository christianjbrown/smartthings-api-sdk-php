<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ScheduleRequestInterface
{
    public function getCron(): ?CronScheduleInterface;

    public function getName(): string;

    public function getOnce(): ?OnceScheduleInterface;

    public function setCron(?CronScheduleInterface $value): self;

    public function setOnce(?OnceScheduleInterface $value): self;
}
