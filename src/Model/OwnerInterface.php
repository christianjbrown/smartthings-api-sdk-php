<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OwnerInterface
{
    public function getOwnerId(): ?string;

    public function getOwnerType(): ?string;
}
