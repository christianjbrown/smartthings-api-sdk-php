<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface InstalledAppListQueryInterface extends QueryParametersInterface
{
    public const string KEY_APP_ID = 'appId';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_INSTALLED_APP_STATUS = 'installedAppStatus';
    public const string KEY_INSTALLED_APP_TYPE = 'installedAppType';
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_MODE_ID = 'modeId';
    public const string KEY_TAG = 'tag';

    public function getAppId(): ?string;

    public function getDeviceId(): ?string;

    public function getInstalledAppStatus(): ?string;

    public function getInstalledAppType(): ?string;

    public function getLocationId(): ?string;

    public function getModeId(): ?string;

    public function getTag(): ?string;

    public function setAppId(?string $value): self;

    public function setDeviceId(?string $value): self;

    public function setInstalledAppStatus(?string $value): self;

    public function setInstalledAppType(?string $value): self;

    public function setLocationId(?string $value): self;

    public function setModeId(?string $value): self;

    public function setTag(?string $value): self;
}
