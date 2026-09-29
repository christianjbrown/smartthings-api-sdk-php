<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PresentationSettingsTemperatureConversionsItemInterface
{
    public function getUnit(): ?string;

    public function getValue(): string;

    public function setUnit(?string $value): self;
}
