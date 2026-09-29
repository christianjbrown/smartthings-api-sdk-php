<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PresentationSettingsInterface
{
    /**
     * @return null|array<int, PresentationSettingsTemperatureConversionsItemInterface>
     */
    public function getTemperatureConversions(): ?array;

    /**
     * @param null|array<int, PresentationSettingsTemperatureConversionsItemInterface> $value
     */
    public function setTemperatureConversions(?array $value): self;
}
