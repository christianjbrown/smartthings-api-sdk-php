<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigEntryForDashboardStateFormatInfoItemTime implements DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface
{
    private ?string $timeFormat;

    public function __construct(?string $timeFormat)
    {
        $this->timeFormat = $timeFormat;
    }

    public function getTimeFormat(): ?string
    {
        return $this->timeFormat;
    }
}
