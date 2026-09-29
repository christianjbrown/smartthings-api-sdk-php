<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ToggleAction implements ToggleActionInterface
{
    private string $attribute;
    private string $capability;
    private string $component;

    /**
     * @var array<int, string>
     */
    private array $devices;

    /**
     * @phpstan-param array<int, string> $devices
     */
    public function __construct(array $devices, string $component, string $capability, string $attribute)
    {
        $this->devices = $devices;
        $this->component = $component;
        $this->capability = $capability;
        $this->attribute = $attribute;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    /**
     * @return array<int, string>
     */
    public function getDevices(): array
    {
        return $this->devices;
    }
}
