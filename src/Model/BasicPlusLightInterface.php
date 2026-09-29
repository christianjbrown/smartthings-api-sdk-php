<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusLightInterface
{
    public function getColorControl(): ?BasicPlusLightColorControlInterface;

    public function getColorTemperature(): ?SliderForLightInterface;

    public function getDimmer(): SliderForLightInterface;

    public function getHideDashboardActions(): ?bool;

    public function setColorControl(?BasicPlusLightColorControlInterface $value): self;

    public function setColorTemperature(?SliderForLightInterface $value): self;

    public function setHideDashboardActions(?bool $value): self;
}
