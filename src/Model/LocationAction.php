<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationAction implements LocationActionInterface
{
    private ?string $locationId = null;
    private ?string $mode = null;

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getMode(): ?string
    {
        return $this->mode;
    }

    public function setLocationId(?string $value): LocationActionInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setMode(?string $value): LocationActionInterface
    {
        $this->mode = $value;

        return $this;
    }
}
