<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TemperatureConversionsItemForDevicePresentationInterface
{
    public function getCapability(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getVersion(): ?int;

    public function setUnit(?string $value): self;

    public function setVersion(?int $value): self;
}
