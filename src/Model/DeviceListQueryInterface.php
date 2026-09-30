<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceListQueryInterface extends QueryParametersInterface
{
    public const string KEY_ACCESS_LEVEL = 'accessLevel';
    public const string KEY_CAPABILITIES_MODE = 'capabilitiesMode';
    public const string KEY_CAPABILITY = 'capability';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_INCLUDE_ALLOWED_ACTIONS = 'includeAllowedActions';
    public const string KEY_INCLUDE_HEALTH = 'includeHealth';
    public const string KEY_INCLUDE_RESTRICTED = 'includeRestricted';
    public const string KEY_INCLUDE_STATUS = 'includeStatus';
    public const string KEY_LOCATION_ID = 'locationId';

    public function getAccessLevel(): ?int;

    /**
     * @return null|array<int, string>
     */
    public function getCapabilities(): ?array;

    public function getCapabilitiesMode(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getDeviceIds(): ?array;

    public function getIncludeAllowedActions(): ?bool;

    public function getIncludeHealth(): ?bool;

    public function getIncludeRestricted(): ?bool;

    public function getIncludeStatus(): ?bool;

    /**
     * @return null|array<int, string>
     */
    public function getLocationIds(): ?array;

    public function setAccessLevel(?int $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setCapabilities(?array $value): self;

    public function setCapabilitiesMode(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setDeviceIds(?array $value): self;

    public function setIncludeAllowedActions(?bool $value): self;

    public function setIncludeHealth(?bool $value): self;

    public function setIncludeRestricted(?bool $value): self;

    public function setIncludeStatus(?bool $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setLocationIds(?array $value): self;
}
