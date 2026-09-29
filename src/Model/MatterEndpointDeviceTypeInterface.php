<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MatterEndpointDeviceTypeInterface
{
    public function getDeviceTypeId(): ?float;

    public function setDeviceTypeId(?float $value): self;
}
