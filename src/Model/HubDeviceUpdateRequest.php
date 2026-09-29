<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDeviceUpdateRequest implements HubDeviceUpdateRequestInterface
{
    private ?DeviceIntegrationProfileKeyInterface $deviceIntegrationProfileKey = null;
    private string $driverId;
    private ?string $provisioningState = null;

    public function __construct(string $driverId)
    {
        $this->driverId = $driverId;
    }

    public function getDeviceIntegrationProfileKey(): ?DeviceIntegrationProfileKeyInterface
    {
        return $this->deviceIntegrationProfileKey;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getProvisioningState(): ?string
    {
        return $this->provisioningState;
    }

    public function setDeviceIntegrationProfileKey(?DeviceIntegrationProfileKeyInterface $value): HubDeviceUpdateRequestInterface
    {
        $this->deviceIntegrationProfileKey = $value;

        return $this;
    }

    public function setProvisioningState(?string $value): HubDeviceUpdateRequestInterface
    {
        $this->provisioningState = $value;

        return $this;
    }
}
