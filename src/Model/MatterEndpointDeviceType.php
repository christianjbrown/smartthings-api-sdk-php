<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class MatterEndpointDeviceType implements MatterEndpointDeviceTypeInterface
{
    private ?float $deviceTypeId = null;

    public function getDeviceTypeId(): ?float
    {
        return $this->deviceTypeId;
    }

    public function setDeviceTypeId(?float $value): MatterEndpointDeviceTypeInterface
    {
        $this->deviceTypeId = $value;

        return $this;
    }
}
