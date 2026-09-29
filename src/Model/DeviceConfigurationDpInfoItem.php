<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfigurationDpInfoItem implements DeviceConfigurationDpInfoItemInterface
{
    /**
     * @var null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface>
     */
    private ?array $arguments = null;
    private string $dpUri;
    private ?string $operatingMode = null;
    private string $os;
    private ?string $serverDpUri = null;

    public function __construct(string $os, string $dpUri)
    {
        $this->os = $os;
        $this->dpUri = $dpUri;
    }

    /**
     * @return null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface>
     */
    public function getArguments(): ?array
    {
        return $this->arguments;
    }

    public function getDpUri(): string
    {
        return $this->dpUri;
    }

    public function getOperatingMode(): ?string
    {
        return $this->operatingMode;
    }

    public function getOs(): string
    {
        return $this->os;
    }

    public function getServerDpUri(): ?string
    {
        return $this->serverDpUri;
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface> $value
     */
    public function setArguments(?array $value): DeviceConfigurationDpInfoItemInterface
    {
        $this->arguments = $value;

        return $this;
    }

    public function setOperatingMode(?string $value): DeviceConfigurationDpInfoItemInterface
    {
        $this->operatingMode = $value;

        return $this;
    }

    public function setServerDpUri(?string $value): DeviceConfigurationDpInfoItemInterface
    {
        $this->serverDpUri = $value;

        return $this;
    }
}
