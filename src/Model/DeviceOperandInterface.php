<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceOperandInterface
{
    public function getAggregation(): ?string;

    public function getAttribute(): string;

    public function getCapability(): string;

    public function getComponent(): string;

    /**
     * @return array<int, string>
     */
    public function getDevices(): array;

    public function getPath(): ?string;

    public function getTrigger(): ?string;

    public function setAggregation(?string $value): self;

    public function setPath(?string $value): self;

    public function setTrigger(?string $value): self;
}
