<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface EdgeDriverSupportedEndpointAppsAppsItemInterface
{
    public function getAppName(): ?string;

    public function getVersion(): ?string;
}
