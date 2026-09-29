<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceRelationship implements DeviceRelationshipInterface
{
    private ?string $deviceId = null;
    private ?string $onDelete = null;
    private ?string $onLocationMove = null;
    private ?string $onOwnershipTransfer = null;
    private ?string $relationshipType = null;

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function getOnDelete(): ?string
    {
        return $this->onDelete;
    }

    public function getOnLocationMove(): ?string
    {
        return $this->onLocationMove;
    }

    public function getOnOwnershipTransfer(): ?string
    {
        return $this->onOwnershipTransfer;
    }

    public function getRelationshipType(): ?string
    {
        return $this->relationshipType;
    }

    public function setDeviceId(?string $value): DeviceRelationshipInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setOnDelete(?string $value): DeviceRelationshipInterface
    {
        $this->onDelete = $value;

        return $this;
    }

    public function setOnLocationMove(?string $value): DeviceRelationshipInterface
    {
        $this->onLocationMove = $value;

        return $this;
    }

    public function setOnOwnershipTransfer(?string $value): DeviceRelationshipInterface
    {
        $this->onOwnershipTransfer = $value;

        return $this;
    }

    public function setRelationshipType(?string $value): DeviceRelationshipInterface
    {
        $this->relationshipType = $value;

        return $this;
    }
}
