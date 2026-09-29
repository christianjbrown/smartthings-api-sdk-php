<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigEntryForDashboardStateFormatInfoItemInterface
{
    public function getKey(): string;

    public function getRemainingTime(): ?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface;

    public function getTime(): ?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface;

    public function getType(): string;

    public function setRemainingTime(?DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface $value): self;

    public function setTime(?DeviceConfigEntryForDashboardStateFormatInfoItemTimeInterface $value): self;
}
