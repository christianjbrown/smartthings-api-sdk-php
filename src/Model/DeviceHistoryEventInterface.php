<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceHistoryEventInterface
{
    public function getAttribute(): ?string;

    public function getCapability(): ?string;

    public function getComponent(): ?string;

    public function getDeviceId(): string;

    public function getEpoch(): ?int;

    public function getLocationId(): ?string;

    public function getValue(): ?string;

    public function setAttribute(?string $value): self;

    public function setCapability(?string $value): self;

    public function setComponent(?string $value): self;

    public function setDeviceId(string $value): self;

    public function setEpoch(?int $value): self;

    public function setLocationId(?string $value): self;

    public function setValue(?string $value): self;
}
