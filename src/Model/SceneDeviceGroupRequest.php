<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneDeviceGroupRequest implements SceneDeviceGroupRequestInterface
{
    private ?string $actionId = null;
    private ?SceneCapabilityInterface $capability = null;
    private ?string $deviceGroupId;

    public function __construct(?string $deviceGroupId)
    {
        $this->deviceGroupId = $deviceGroupId;
    }

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    public function getCapability(): ?SceneCapabilityInterface
    {
        return $this->capability;
    }

    public function getDeviceGroupId(): ?string
    {
        return $this->deviceGroupId;
    }

    public function setActionId(?string $value): SceneDeviceGroupRequestInterface
    {
        $this->actionId = $value;

        return $this;
    }

    public function setCapability(?SceneCapabilityInterface $value): SceneDeviceGroupRequestInterface
    {
        $this->capability = $value;

        return $this;
    }
}
