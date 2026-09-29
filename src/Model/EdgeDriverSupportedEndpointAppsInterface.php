<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EdgeDriverSupportedEndpointAppsInterface
{
    /**
     * @return array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface>
     */
    public function getApps(): array;
}
