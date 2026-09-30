<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusLight implements BasicPlusLightInterface
{
    private ?BasicPlusLightColorControlInterface $colorControl = null;
    private ?SliderForLightInterface $colorTemperature = null;
    private ?SliderForLightInterface $dimmer;
    private ?bool $hideDashboardActions = null;

    public function __construct(?SliderForLightInterface $dimmer)
    {
        $this->dimmer = $dimmer;
    }

    public function getColorControl(): ?BasicPlusLightColorControlInterface
    {
        return $this->colorControl;
    }

    public function getColorTemperature(): ?SliderForLightInterface
    {
        return $this->colorTemperature;
    }

    public function getDimmer(): ?SliderForLightInterface
    {
        return $this->dimmer;
    }

    public function getHideDashboardActions(): ?bool
    {
        return $this->hideDashboardActions;
    }

    public function setColorControl(?BasicPlusLightColorControlInterface $value): BasicPlusLightInterface
    {
        $this->colorControl = $value;

        return $this;
    }

    public function setColorTemperature(?SliderForLightInterface $value): BasicPlusLightInterface
    {
        $this->colorTemperature = $value;

        return $this;
    }

    public function setHideDashboardActions(?bool $value): BasicPlusLightInterface
    {
        $this->hideDashboardActions = $value;

        return $this;
    }
}
