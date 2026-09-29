<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PresentationSettings implements PresentationSettingsInterface
{
    /**
     * @var null|array<int, PresentationSettingsTemperatureConversionsItemInterface>
     */
    private ?array $temperatureConversions = null;

    /**
     * @return null|array<int, PresentationSettingsTemperatureConversionsItemInterface>
     */
    public function getTemperatureConversions(): ?array
    {
        return $this->temperatureConversions;
    }

    /**
     * @param null|array<int, PresentationSettingsTemperatureConversionsItemInterface> $value
     */
    public function setTemperatureConversions(?array $value): PresentationSettingsInterface
    {
        $this->temperatureConversions = $value;

        return $this;
    }
}
