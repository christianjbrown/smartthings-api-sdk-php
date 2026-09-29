<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BasicPlusCameraInterface
{
    public function getImage(): BasicPlusCameraImageInterface;

    /**
     * @return null|array<int, BasicPlusCameraOverlayIconsItemInterface>
     */
    public function getOverlayIcons(): ?array;

    /**
     * @param null|array<int, BasicPlusCameraOverlayIconsItemInterface> $value
     */
    public function setOverlayIcons(?array $value): self;
}
