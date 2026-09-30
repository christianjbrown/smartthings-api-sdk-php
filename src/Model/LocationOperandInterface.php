<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocationOperandInterface
{
    public function getAttribute(): ?string;

    public function getLocationId(): ?string;

    public function getPostalCode(): ?string;

    public function getTrigger(): ?string;

    public function setLocationId(?string $value): self;

    public function setPostalCode(?string $value): self;

    public function setTrigger(?string $value): self;
}
