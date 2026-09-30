<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class InstalledAppListQuery implements InstalledAppListQueryInterface
{
    private ?string $appId = null;
    private ?string $deviceId = null;
    private ?string $installedAppStatus = null;
    private ?string $installedAppType = null;
    private ?string $locationId = null;
    private ?string $modeId = null;
    private ?string $tag = null;

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function getInstalledAppStatus(): ?string
    {
        return $this->installedAppStatus;
    }

    public function getInstalledAppType(): ?string
    {
        return $this->installedAppType;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getModeId(): ?string
    {
        return $this->modeId;
    }

    /**
     * @return array<string, null|array<int, string>|bool|int|string>
     */
    public function getParameters(): array
    {
        return [
            self::KEY_APP_ID => $this->appId,
            self::KEY_DEVICE_ID => $this->deviceId,
            self::KEY_INSTALLED_APP_STATUS => $this->installedAppStatus,
            self::KEY_INSTALLED_APP_TYPE => $this->installedAppType,
            self::KEY_LOCATION_ID => $this->locationId,
            self::KEY_MODE_ID => $this->modeId,
            self::KEY_TAG => $this->tag,
        ];
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setAppId(?string $value): InstalledAppListQueryInterface
    {
        $this->appId = $value;

        return $this;
    }

    public function setDeviceId(?string $value): InstalledAppListQueryInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setInstalledAppStatus(?string $value): InstalledAppListQueryInterface
    {
        $this->installedAppStatus = $value;

        return $this;
    }

    public function setInstalledAppType(?string $value): InstalledAppListQueryInterface
    {
        $this->installedAppType = $value;

        return $this;
    }

    public function setLocationId(?string $value): InstalledAppListQueryInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setModeId(?string $value): InstalledAppListQueryInterface
    {
        $this->modeId = $value;

        return $this;
    }

    public function setTag(?string $value): InstalledAppListQueryInterface
    {
        $this->tag = $value;

        return $this;
    }
}
