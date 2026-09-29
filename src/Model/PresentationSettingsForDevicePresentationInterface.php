<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PresentationSettingsForDevicePresentationInterface
{
    /**
     * @return null|array<int, TemperatureConversionsItemForDevicePresentationInterface>
     */
    public function getTemperatureConversions(): ?array;

    /**
     * @param null|array<int, TemperatureConversionsItemForDevicePresentationInterface> $value
     */
    public function setTemperatureConversions(?array $value): self;
}
