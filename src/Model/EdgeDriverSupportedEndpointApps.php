<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class EdgeDriverSupportedEndpointApps implements EdgeDriverSupportedEndpointAppsInterface
{
    /**
     * @var array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface>
     */
    private array $apps;

    /**
     * @phpstan-param array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface> $apps
     */
    public function __construct(array $apps)
    {
        $this->apps = $apps;
    }

    /**
     * @return array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface>
     */
    public function getApps(): array
    {
        return $this->apps;
    }
}
