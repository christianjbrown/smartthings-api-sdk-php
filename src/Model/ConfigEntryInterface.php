<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ConfigEntryInterface
{
    public function getDeviceConfig(): ?DeviceConfigInterface;

    public function getMessageConfig(): ?MessageConfigInterface;

    public function getModeConfig(): ?ModeConfigInterface;

    public function getPermissionConfig(): ?PermissionConfigInterface;

    public function getRoomConfig(): ?RoomConfigInterface;

    public function getSceneConfig(): ?SceneConfigInterface;

    public function getStringConfig(): ?StringConfigInterface;

    public function getValueType(): ?string;

    public function setDeviceConfig(?DeviceConfigInterface $value): self;

    public function setMessageConfig(?MessageConfigInterface $value): self;

    public function setModeConfig(?ModeConfigInterface $value): self;

    public function setPermissionConfig(?PermissionConfigInterface $value): self;

    public function setRoomConfig(?RoomConfigInterface $value): self;

    public function setSceneConfig(?SceneConfigInterface $value): self;

    public function setStringConfig(?StringConfigInterface $value): self;

    public function setValueType(?string $value): self;
}
