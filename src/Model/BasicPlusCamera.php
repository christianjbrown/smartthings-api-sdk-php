<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class BasicPlusCamera implements BasicPlusCameraInterface
{
    private BasicPlusCameraImageInterface $image;

    /**
     * @var null|array<int, BasicPlusCameraOverlayIconsItemInterface>
     */
    private ?array $overlayIcons = null;

    public function __construct(BasicPlusCameraImageInterface $image)
    {
        $this->image = $image;
    }

    public function getImage(): BasicPlusCameraImageInterface
    {
        return $this->image;
    }

    /**
     * @return null|array<int, BasicPlusCameraOverlayIconsItemInterface>
     */
    public function getOverlayIcons(): ?array
    {
        return $this->overlayIcons;
    }

    /**
     * @param null|array<int, BasicPlusCameraOverlayIconsItemInterface> $value
     */
    public function setOverlayIcons(?array $value): BasicPlusCameraInterface
    {
        $this->overlayIcons = $value;

        return $this;
    }
}
