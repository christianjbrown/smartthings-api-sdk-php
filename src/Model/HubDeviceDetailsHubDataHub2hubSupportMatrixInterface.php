<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDeviceDetailsHubDataHub2hubSupportMatrixInterface
{
    /**
     * @return array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface>
     */
    public function getCapabilities(): array;
}
