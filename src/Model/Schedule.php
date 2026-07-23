<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Schedule implements ScheduleInterface
{
    private ?string $installedAppId = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setInstalledAppId(?string $value): ScheduleInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setName(string $value): ScheduleInterface
    {
        $this->name = $value;

        return $this;
    }
}
