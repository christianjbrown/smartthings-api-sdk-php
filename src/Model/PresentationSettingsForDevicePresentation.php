<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PresentationSettingsForDevicePresentation implements PresentationSettingsForDevicePresentationInterface
{
    /**
     * @var null|array<int, TemperatureConversionsItemForDevicePresentationInterface>
     */
    private ?array $temperatureConversions = null;

    /**
     * @return null|array<int, TemperatureConversionsItemForDevicePresentationInterface>
     */
    public function getTemperatureConversions(): ?array
    {
        return $this->temperatureConversions;
    }

    /**
     * @param null|array<int, TemperatureConversionsItemForDevicePresentationInterface> $value
     */
    public function setTemperatureConversions(?array $value): PresentationSettingsForDevicePresentationInterface
    {
        $this->temperatureConversions = $value;

        return $this;
    }
}
