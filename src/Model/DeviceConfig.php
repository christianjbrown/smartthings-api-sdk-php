<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceConfig implements DeviceConfigInterface
{
    private ?string $componentId = null;
    private ?string $deviceId = null;

    /**
     * @var array<int, string>
     */
    private array $permissions = [];

    public function getComponentId(): ?string
    {
        return $this->componentId;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    /**
     * @return array<int, string>
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function setComponentId(?string $value): DeviceConfigInterface
    {
        $this->componentId = $value;

        return $this;
    }

    public function setDeviceId(?string $value): DeviceConfigInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setPermissions(array $value): DeviceConfigInterface
    {
        $this->permissions = $value;

        return $this;
    }
}
