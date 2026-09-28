<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PatchLocationRequestInterface
{
    public function getLatitude(): ?LocationPatchFieldInterface;

    public function getLongitude(): ?LocationPatchFieldInterface;

    public function getRegionRadius(): ?LocationPatchFieldInterface;

    public function setLatitude(?LocationPatchFieldInterface $value): self;

    public function setLongitude(?LocationPatchFieldInterface $value): self;

    public function setRegionRadius(?LocationPatchFieldInterface $value): self;
}
