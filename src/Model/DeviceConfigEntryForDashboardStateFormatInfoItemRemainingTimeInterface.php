<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigEntryForDashboardStateFormatInfoItemRemainingTimeInterface
{
    public function getFrequency(): ?int;

    public function getTimeFormat(): string;

    public function setFrequency(?int $value): self;
}
