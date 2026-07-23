<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityNamespace implements CapabilityNamespaceInterface
{
    private string $name;
    private ?string $ownerId = null;
    private ?string $ownerType = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function getOwnerType(): ?string
    {
        return $this->ownerType;
    }

    public function setName(string $value): CapabilityNamespaceInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOwnerId(?string $value): CapabilityNamespaceInterface
    {
        $this->ownerId = $value;

        return $this;
    }

    public function setOwnerType(?string $value): CapabilityNamespaceInterface
    {
        $this->ownerType = $value;

        return $this;
    }
}
