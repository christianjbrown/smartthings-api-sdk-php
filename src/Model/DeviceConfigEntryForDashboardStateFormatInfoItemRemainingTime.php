<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTime implements DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface
{
    private ?int $frequency = null;
    private string $timeFormat;

    public function __construct(string $timeFormat)
    {
        $this->timeFormat = $timeFormat;
    }

    public function getFrequency(): ?int
    {
        return $this->frequency;
    }

    public function getTimeFormat(): string
    {
        return $this->timeFormat;
    }

    public function setFrequency(?int $value): DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface
    {
        $this->frequency = $value;

        return $this;
    }
}
