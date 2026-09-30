<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusCameraOverlayIconsItem implements BasicPlusCameraOverlayIconsItemInterface
{
    private ?string $iconUrl;
    private ?VisibleConditionInterface $visibleCondition = null;

    public function __construct(?string $iconUrl)
    {
        $this->iconUrl = $iconUrl;
    }

    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }

    public function getVisibleCondition(): ?VisibleConditionInterface
    {
        return $this->visibleCondition;
    }

    public function setVisibleCondition(?VisibleConditionInterface $value): BasicPlusCameraOverlayIconsItemInterface
    {
        $this->visibleCondition = $value;

        return $this;
    }
}
