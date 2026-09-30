<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EdgeDriverSupportedEndpointAppsAppsItem implements EdgeDriverSupportedEndpointAppsAppsItemInterface
{
    private ?string $appName;
    private ?string $version;

    public function __construct(?string $appName, ?string $version)
    {
        $this->appName = $appName;
        $this->version = $version;
    }

    public function getAppName(): ?string
    {
        return $this->appName;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }
}
