<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceStatusReport implements DeviceStatusReportInterface
{
    /**
     * @var array<array-key, ComponentStatusInterface>
     */
    private array $components = [];
    private ?IdLessHealthStateInterface $healthState = null;

    /**
     * @return array<array-key, ComponentStatusInterface>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getHealthState(): ?IdLessHealthStateInterface
    {
        return $this->healthState;
    }

    /**
     * @param array<array-key, ComponentStatusInterface> $value
     */
    public function setComponents(array $value): DeviceStatusReportInterface
    {
        $this->components = $value;

        return $this;
    }

    public function setHealthState(?IdLessHealthStateInterface $value): DeviceStatusReportInterface
    {
        $this->healthState = $value;

        return $this;
    }
}
