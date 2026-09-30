<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Owner implements OwnerInterface
{
    private ?string $ownerId;
    private ?string $ownerType;

    public function __construct(?string $ownerType, ?string $ownerId)
    {
        $this->ownerType = $ownerType;
        $this->ownerId = $ownerId;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function getOwnerType(): ?string
    {
        return $this->ownerType;
    }
}
