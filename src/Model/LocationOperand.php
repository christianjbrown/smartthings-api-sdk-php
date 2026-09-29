<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationOperand implements LocationOperandInterface
{
    private string $attribute;
    private ?string $locationId = null;
    private ?string $postalCode = null;
    private ?string $trigger = null;

    public function __construct(string $attribute)
    {
        $this->attribute = $attribute;
    }

    public function getAttribute(): string
    {
        return $this->attribute;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function getTrigger(): ?string
    {
        return $this->trigger;
    }

    public function setLocationId(?string $value): LocationOperandInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setPostalCode(?string $value): LocationOperandInterface
    {
        $this->postalCode = $value;

        return $this;
    }

    public function setTrigger(?string $value): LocationOperandInterface
    {
        $this->trigger = $value;

        return $this;
    }
}
