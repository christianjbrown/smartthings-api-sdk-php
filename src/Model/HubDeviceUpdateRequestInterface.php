<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDeviceUpdateRequestInterface
{
    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface;

    public function getDriverId(): string;

    public function getProvisioningState(): ?string;

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): self;

    public function setProvisioningState(?string $value): self;
}
