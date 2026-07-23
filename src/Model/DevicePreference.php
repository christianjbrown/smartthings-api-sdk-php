<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DevicePreference implements DevicePreferenceInterface
{
    private string $name;
    private ?string $preferenceType = null;
    private null|bool|float|int|string $value = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPreferenceType(): ?string
    {
        return $this->preferenceType;
    }

    public function getValue(): null|bool|float|int|string
    {
        return $this->value;
    }

    public function setName(string $value): DevicePreferenceInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setPreferenceType(?string $value): DevicePreferenceInterface
    {
        $this->preferenceType = $value;

        return $this;
    }

    public function setValue(null|bool|float|int|string $value): DevicePreferenceInterface
    {
        $this->value = $value;

        return $this;
    }
}
