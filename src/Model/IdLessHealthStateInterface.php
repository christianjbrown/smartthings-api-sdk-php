<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IdLessHealthStateInterface
{
    public function getLastUpdatedDate(): ?string;

    public function getState(): ?string;

    public function setLastUpdatedDate(?string $value): self;

    public function setState(?string $value): self;
}
