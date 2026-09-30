<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceListQuery implements DeviceListQueryInterface
{
    private ?int $accessLevel = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $capabilities = null;
    private ?string $capabilitiesMode = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $deviceIds = null;
    private ?bool $includeAllowedActions = null;
    private ?bool $includeHealth = null;
    private ?bool $includeRestricted = null;
    private ?bool $includeStatus = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $locationIds = null;

    public function getAccessLevel(): ?int
    {
        return $this->accessLevel;
    }

    /**
     * @return null|array<int, string>
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    public function getCapabilitiesMode(): ?string
    {
        return $this->capabilitiesMode;
    }

    /**
     * @return null|array<int, string>
     */
    public function getDeviceIds(): ?array
    {
        return $this->deviceIds;
    }

    public function getIncludeAllowedActions(): ?bool
    {
        return $this->includeAllowedActions;
    }

    public function getIncludeHealth(): ?bool
    {
        return $this->includeHealth;
    }

    public function getIncludeRestricted(): ?bool
    {
        return $this->includeRestricted;
    }

    public function getIncludeStatus(): ?bool
    {
        return $this->includeStatus;
    }

    /**
     * @return null|array<int, string>
     */
    public function getLocationIds(): ?array
    {
        return $this->locationIds;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_ACCESS_LEVEL => $this->accessLevel,
            self::KEY_CAPABILITIES_MODE => $this->capabilitiesMode,
            self::KEY_CAPABILITY => $this->capabilities,
            self::KEY_DEVICE_ID => $this->deviceIds,
            self::KEY_INCLUDE_ALLOWED_ACTIONS => $this->includeAllowedActions,
            self::KEY_INCLUDE_HEALTH => $this->includeHealth,
            self::KEY_INCLUDE_RESTRICTED => $this->includeRestricted,
            self::KEY_INCLUDE_STATUS => $this->includeStatus,
            self::KEY_LOCATION_ID => $this->locationIds,
        ];
    }

    public function setAccessLevel(?int $value): DeviceListQueryInterface
    {
        $this->accessLevel = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setCapabilities(?array $value): DeviceListQueryInterface
    {
        $this->capabilities = $value;

        return $this;
    }

    public function setCapabilitiesMode(?string $value): DeviceListQueryInterface
    {
        $this->capabilitiesMode = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setDeviceIds(?array $value): DeviceListQueryInterface
    {
        $this->deviceIds = $value;

        return $this;
    }

    public function setIncludeAllowedActions(?bool $value): DeviceListQueryInterface
    {
        $this->includeAllowedActions = $value;

        return $this;
    }

    public function setIncludeHealth(?bool $value): DeviceListQueryInterface
    {
        $this->includeHealth = $value;

        return $this;
    }

    public function setIncludeRestricted(?bool $value): DeviceListQueryInterface
    {
        $this->includeRestricted = $value;

        return $this;
    }

    public function setIncludeStatus(?bool $value): DeviceListQueryInterface
    {
        $this->includeStatus = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setLocationIds(?array $value): DeviceListQueryInterface
    {
        $this->locationIds = $value;

        return $this;
    }
}
