<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceHealthInterface
{
    public function getDeviceId(): string;

    public function getLastUpdatedDate(): ?int;

    public function getState(): ?string;

    public function setDeviceId(string $value): self;

    public function setLastUpdatedDate(?int $value): self;

    public function setState(?string $value): self;
}
