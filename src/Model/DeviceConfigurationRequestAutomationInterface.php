<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationRequestAutomationInterface
{
    /**
     * @return null|array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, ExcludedDeviceConditionConfigEntryInterface>
     */
    public function getConditions(): ?array;

    /**
     * @param null|array<int, ExcludedDeviceActionConfigEntryInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, ExcludedDeviceConditionConfigEntryInterface> $value
     */
    public function setConditions(?array $value): self;
}
