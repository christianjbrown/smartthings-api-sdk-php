<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationDetails implements LocationDetailsInterface
{
    private ?LocationParentInterface $parent = null;

    public function getParent(): ?LocationParentInterface
    {
        return $this->parent;
    }

    public function setParent(?LocationParentInterface $value): LocationDetailsInterface
    {
        $this->parent = $value;

        return $this;
    }
}
