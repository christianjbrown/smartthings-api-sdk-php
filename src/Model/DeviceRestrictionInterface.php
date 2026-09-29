<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceRestrictionInterface
{
    public function getHistoryRetentionTTLDays(): ?int;

    public function getTier(): int;

    public function getVisibleWhenRestricted(): ?bool;

    public function setHistoryRetentionTTLDays(?int $value): self;

    public function setVisibleWhenRestricted(?bool $value): self;
}
