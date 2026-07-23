<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PresentationInterface
{
    public function getManufacturerName(): ?string;

    public function getPresentationId(): string;

    public function getType(): ?string;

    public function setManufacturerName(?string $value): self;

    public function setPresentationId(string $value): self;

    public function setType(?string $value): self;
}
