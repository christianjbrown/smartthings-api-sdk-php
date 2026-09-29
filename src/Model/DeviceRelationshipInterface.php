<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceRelationshipInterface
{
    public function getDeviceId(): ?string;

    public function getOnDelete(): ?string;

    public function getOnLocationMove(): ?string;

    public function getOnOwnershipTransfer(): ?string;

    public function getRelationshipType(): ?string;

    public function setDeviceId(?string $value): self;

    public function setOnDelete(?string $value): self;

    public function setOnLocationMove(?string $value): self;

    public function setOnOwnershipTransfer(?string $value): self;

    public function setRelationshipType(?string $value): self;
}
