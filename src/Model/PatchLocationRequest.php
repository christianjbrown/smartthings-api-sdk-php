<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PatchLocationRequest implements PatchLocationRequestInterface
{
    private ?LocationPatchFieldInterface $latitude = null;
    private ?LocationPatchFieldInterface $longitude = null;
    private ?LocationPatchFieldInterface $regionRadius = null;

    public function getLatitude(): ?LocationPatchFieldInterface
    {
        return $this->latitude;
    }

    public function getLongitude(): ?LocationPatchFieldInterface
    {
        return $this->longitude;
    }

    public function getRegionRadius(): ?LocationPatchFieldInterface
    {
        return $this->regionRadius;
    }

    public function setLatitude(?LocationPatchFieldInterface $value): PatchLocationRequestInterface
    {
        $this->latitude = $value;

        return $this;
    }

    public function setLongitude(?LocationPatchFieldInterface $value): PatchLocationRequestInterface
    {
        $this->longitude = $value;

        return $this;
    }

    public function setRegionRadius(?LocationPatchFieldInterface $value): PatchLocationRequestInterface
    {
        $this->regionRadius = $value;

        return $this;
    }
}
