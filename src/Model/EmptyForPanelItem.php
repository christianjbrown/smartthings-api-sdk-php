<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EmptyForPanelItem implements EmptyForPanelItemInterface
{
    private ?string $size;

    public function __construct(?string $size)
    {
        $this->size = $size;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }
}
