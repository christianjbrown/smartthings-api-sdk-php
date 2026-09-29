<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IrDeviceDetailsFunctionCodesInterface
{
    public function getDefault(): ?string;

    public function setDefault(?string $value): self;
}
