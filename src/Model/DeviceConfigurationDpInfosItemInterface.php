<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceConfigurationDpInfosItemInterface
{
    /**
     * @return array<int, DeviceConfigurationDpInfoItemInterface>
     */
    public function getDpInfo(): array;

    public function getStPluginApiVersion(): ?string;

    public function setStPluginApiVersion(?string $value): self;
}
