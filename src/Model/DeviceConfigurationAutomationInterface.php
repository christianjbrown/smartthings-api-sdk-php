<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationAutomationInterface
{
    /**
     * @return null|array<int, ExcludedDeviceActionConfigEntryInterface>
     */
    public function getActions(): ?array;

    /**
     * @return null|array<int, ExcludedDeviceConditionConfigEntryInterface>
     */
    public function getConditions(): ?array;

    public function getDescriptions(): ?DescriptionsInAutomationInterface;

    /**
     * @param null|array<int, ExcludedDeviceActionConfigEntryInterface> $value
     */
    public function setActions(?array $value): self;

    /**
     * @param null|array<int, ExcludedDeviceConditionConfigEntryInterface> $value
     */
    public function setConditions(?array $value): self;

    public function setDescriptions(?DescriptionsInAutomationInterface $value): self;
}
