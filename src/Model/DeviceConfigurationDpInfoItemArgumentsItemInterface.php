<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationDpInfoItemArgumentsItemInterface
{
    public function getKey(): ?string;

    public function getValue(): ?string;
}
