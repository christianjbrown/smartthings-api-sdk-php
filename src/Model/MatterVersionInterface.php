<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MatterVersionInterface
{
    public function getHardware(): ?int;

    public function getHardwareLabel(): ?string;

    public function getSoftware(): ?float;

    public function getSoftwareLabel(): ?string;

    public function setHardware(?int $value): self;

    public function setHardwareLabel(?string $value): self;

    public function setSoftware(?float $value): self;

    public function setSoftwareLabel(?string $value): self;
}
