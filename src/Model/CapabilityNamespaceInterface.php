<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityNamespaceInterface
{
    public function getName(): string;

    public function getOwnerId(): ?string;

    public function getOwnerType(): ?string;

    public function setName(string $value): self;

    public function setOwnerId(?string $value): self;

    public function setOwnerType(?string $value): self;
}
