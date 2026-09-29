<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigEntryForDashboardStateFormatInfoItem implements DeviceConfigEntryForDashboardStateFormatInfoItemInterface
{
    private string $key;
    private ?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $remainingTime = null;
    private ?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $time = null;
    private string $type;

    public function __construct(string $key, string $type)
    {
        $this->key = $key;
        $this->type = $type;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getRemainingTime(): ?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface
    {
        return $this->remainingTime;
    }

    public function getTime(): ?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface
    {
        return $this->time;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setRemainingTime(?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $value): DeviceConfigEntryForDashboardStateFormatInfoItemInterface
    {
        $this->remainingTime = $value;

        return $this;
    }

    public function setTime(?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $value): DeviceConfigEntryForDashboardStateFormatInfoItemInterface
    {
        $this->time = $value;

        return $this;
    }
}
