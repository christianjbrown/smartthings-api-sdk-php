<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneAction implements SceneActionInterface
{
    private ?SceneDeviceGroupRequestInterface $deviceGroupRequest = null;
    private ?SceneDeviceRequestInterface $deviceRequest = null;
    private ?SceneModeRequestInterface $modeRequest = null;
    private ?SceneSleepRequestInterface $sleepRequest = null;

    public function getDeviceGroupRequest(): ?SceneDeviceGroupRequestInterface
    {
        return $this->deviceGroupRequest;
    }

    public function getDeviceRequest(): ?SceneDeviceRequestInterface
    {
        return $this->deviceRequest;
    }

    public function getModeRequest(): ?SceneModeRequestInterface
    {
        return $this->modeRequest;
    }

    public function getSleepRequest(): ?SceneSleepRequestInterface
    {
        return $this->sleepRequest;
    }

    public function setDeviceGroupRequest(?SceneDeviceGroupRequestInterface $value): SceneActionInterface
    {
        $this->deviceGroupRequest = $value;

        return $this;
    }

    public function setDeviceRequest(?SceneDeviceRequestInterface $value): SceneActionInterface
    {
        $this->deviceRequest = $value;

        return $this;
    }

    public function setModeRequest(?SceneModeRequestInterface $value): SceneActionInterface
    {
        $this->modeRequest = $value;

        return $this;
    }

    public function setSleepRequest(?SceneSleepRequestInterface $value): SceneActionInterface
    {
        $this->sleepRequest = $value;

        return $this;
    }
}
