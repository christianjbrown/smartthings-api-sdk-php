<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationDpInfosItem implements DeviceConfigurationDpInfosItemInterface
{
    /**
     * @var array<int, DeviceConfigurationDpInfoItemInterface>
     */
    private array $dpInfo;
    private ?string $stPluginApiVersion = null;

    /**
     * @phpstan-param array<int, DeviceConfigurationDpInfoItemInterface> $dpInfo
     */
    public function __construct(array $dpInfo)
    {
        $this->dpInfo = $dpInfo;
    }

    /**
     * @return array<int, DeviceConfigurationDpInfoItemInterface>
     */
    public function getDpInfo(): array
    {
        return $this->dpInfo;
    }

    public function getStPluginApiVersion(): ?string
    {
        return $this->stPluginApiVersion;
    }

    public function setStPluginApiVersion(?string $value): DeviceConfigurationDpInfosItemInterface
    {
        $this->stPluginApiVersion = $value;

        return $this;
    }
}
