<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IrDeviceDetailsFunctionCodes implements IrDeviceDetailsFunctionCodesInterface
{
    private ?string $default = null;

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function setDefault(?string $value): IrDeviceDetailsFunctionCodesInterface
    {
        $this->default = $value;

        return $this;
    }
}
