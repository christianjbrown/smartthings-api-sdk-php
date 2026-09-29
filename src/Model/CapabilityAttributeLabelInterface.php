<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityAttributeLabelInterface
{
    public function getDescription(): ?string;

    public function getLabel(): string;

    public function setDescription(?string $value): self;
}
