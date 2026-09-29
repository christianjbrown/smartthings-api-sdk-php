<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PresentationSettingsTemperatureConversionsItem implements PresentationSettingsTemperatureConversionsItemInterface
{
    private ?string $unit = null;
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setUnit(?string $value): PresentationSettingsTemperatureConversionsItemInterface
    {
        $this->unit = $value;

        return $this;
    }
}
