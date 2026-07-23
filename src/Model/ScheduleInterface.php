<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ScheduleInterface
{
    public function getInstalledAppId(): ?string;

    public function getName(): string;

    public function setInstalledAppId(?string $value): self;

    public function setName(string $value): self;
}
