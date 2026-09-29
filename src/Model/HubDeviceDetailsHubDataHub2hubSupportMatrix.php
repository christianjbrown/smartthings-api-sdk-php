<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDeviceDetailsHubDataHub2hubSupportMatrix implements HubDeviceDetailsHubDataHub2hubSupportMatrixInterface
{
    /**
     * @var array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface>
     */
    private array $capabilities;

    /**
     * @phpstan-param array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface> $capabilities
     */
    public function __construct(array $capabilities)
    {
        $this->capabilities = $capabilities;
    }

    /**
     * @return array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface>
     */
    public function getCapabilities(): array
    {
        return $this->capabilities;
    }
}
