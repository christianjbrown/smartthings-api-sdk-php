<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDeviceDetails implements HubDeviceDetailsInterface
{
    private string $driverId;
    private string $firmwareVersion;
    private HubDeviceDetailsHubDataInterface $hubData;

    /**
     * @var array<int, HubDriverInterface>
     */
    private array $hubDrivers;
    private string $hubEui;

    /**
     * @phpstan-param array<int, HubDriverInterface> $hubDrivers
     */
    public function __construct(string $hubEui, string $firmwareVersion, array $hubDrivers, HubDeviceDetailsHubDataInterface $hubData, string $driverId)
    {
        $this->hubEui = $hubEui;
        $this->firmwareVersion = $firmwareVersion;
        $this->hubDrivers = $hubDrivers;
        $this->hubData = $hubData;
        $this->driverId = $driverId;
    }

    public function getDriverId(): string
    {
        return $this->driverId;
    }

    public function getFirmwareVersion(): string
    {
        return $this->firmwareVersion;
    }

    public function getHubData(): HubDeviceDetailsHubDataInterface
    {
        return $this->hubData;
    }

    /**
     * @return array<int, HubDriverInterface>
     */
    public function getHubDrivers(): array
    {
        return $this->hubDrivers;
    }

    public function getHubEui(): string
    {
        return $this->hubEui;
    }
}
