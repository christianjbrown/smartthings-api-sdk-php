<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IdLessHealthState implements IdLessHealthStateInterface
{
    private ?string $lastUpdatedDate = null;
    private ?string $state = null;

    public function getLastUpdatedDate(): ?string
    {
        return $this->lastUpdatedDate;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setLastUpdatedDate(?string $value): IdLessHealthStateInterface
    {
        $this->lastUpdatedDate = $value;

        return $this;
    }

    public function setState(?string $value): IdLessHealthStateInterface
    {
        $this->state = $value;

        return $this;
    }
}
