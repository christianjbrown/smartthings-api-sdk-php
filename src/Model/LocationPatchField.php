<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocationPatchField implements LocationPatchFieldInterface
{
    private bool $toNull;
    private ?float $value;

    public function __construct(?float $value = null, bool $toNull = false)
    {
        $this->value = $value;
        $this->toNull = $toNull;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function isToNull(): bool
    {
        return $this->toNull;
    }
}
