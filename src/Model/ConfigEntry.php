<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ConfigEntry implements ConfigEntryInterface
{
    private ?DeviceConfigInterface $deviceConfig = null;
    private ?MessageConfigInterface $messageConfig = null;
    private ?ModeConfigInterface $modeConfig = null;
    private ?PermissionConfigInterface $permissionConfig = null;
    private ?RoomConfigInterface $roomConfig = null;
    private ?SceneConfigInterface $sceneConfig = null;
    private ?StringConfigInterface $stringConfig = null;
    private ?string $valueType = null;

    public function getDeviceConfig(): ?DeviceConfigInterface
    {
        return $this->deviceConfig;
    }

    public function getMessageConfig(): ?MessageConfigInterface
    {
        return $this->messageConfig;
    }

    public function getModeConfig(): ?ModeConfigInterface
    {
        return $this->modeConfig;
    }

    public function getPermissionConfig(): ?PermissionConfigInterface
    {
        return $this->permissionConfig;
    }

    public function getRoomConfig(): ?RoomConfigInterface
    {
        return $this->roomConfig;
    }

    public function getSceneConfig(): ?SceneConfigInterface
    {
        return $this->sceneConfig;
    }

    public function getStringConfig(): ?StringConfigInterface
    {
        return $this->stringConfig;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setDeviceConfig(?DeviceConfigInterface $value): ConfigEntryInterface
    {
        $this->deviceConfig = $value;

        return $this;
    }

    public function setMessageConfig(?MessageConfigInterface $value): ConfigEntryInterface
    {
        $this->messageConfig = $value;

        return $this;
    }

    public function setModeConfig(?ModeConfigInterface $value): ConfigEntryInterface
    {
        $this->modeConfig = $value;

        return $this;
    }

    public function setPermissionConfig(?PermissionConfigInterface $value): ConfigEntryInterface
    {
        $this->permissionConfig = $value;

        return $this;
    }

    public function setRoomConfig(?RoomConfigInterface $value): ConfigEntryInterface
    {
        $this->roomConfig = $value;

        return $this;
    }

    public function setSceneConfig(?SceneConfigInterface $value): ConfigEntryInterface
    {
        $this->sceneConfig = $value;

        return $this;
    }

    public function setStringConfig(?StringConfigInterface $value): ConfigEntryInterface
    {
        $this->stringConfig = $value;

        return $this;
    }

    public function setValueType(?string $value): ConfigEntryInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
