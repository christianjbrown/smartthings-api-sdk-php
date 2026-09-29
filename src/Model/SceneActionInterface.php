<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneActionInterface
{
    public function getDeviceGroupRequest(): ?SceneDeviceGroupRequestInterface;

    public function getDeviceRequest(): ?SceneDeviceRequestInterface;

    public function getModeRequest(): ?SceneModeRequestInterface;

    public function getSleepRequest(): ?SceneSleepRequestInterface;

    public function setDeviceGroupRequest(?SceneDeviceGroupRequestInterface $value): self;

    public function setDeviceRequest(?SceneDeviceRequestInterface $value): self;

    public function setModeRequest(?SceneModeRequestInterface $value): self;

    public function setSleepRequest(?SceneSleepRequestInterface $value): self;
}
