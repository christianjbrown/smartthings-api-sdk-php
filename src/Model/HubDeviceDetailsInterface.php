<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDeviceDetailsInterface
{
    public function getDriverId(): ?string;

    public function getFirmwareVersion(): ?string;

    public function getHubData(): ?HubDeviceDetailsHubDataInterface;

    /**
     * @return array<int, HubDriverInterface>
     */
    public function getHubDrivers(): array;

    public function getHubEui(): ?string;
}
