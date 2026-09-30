<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusCameraOverlayIconsItemInterface
{
    public function getIconUrl(): ?string;

    public function getVisibleCondition(): ?VisibleConditionInterface;

    public function setVisibleCondition(?VisibleConditionInterface $value): self;
}
