<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceStatusReportInterface
{
    /**
     * @return array<array-key, ComponentStatusInterface>
     */
    public function getComponents(): array;

    public function getHealthState(): ?IdLessHealthStateInterface;

    /**
     * @param array<array-key, ComponentStatusInterface> $value
     */
    public function setComponents(array $value): self;

    public function setHealthState(?IdLessHealthStateInterface $value): self;
}
