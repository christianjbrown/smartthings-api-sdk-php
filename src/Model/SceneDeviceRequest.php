<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneDeviceRequest implements SceneDeviceRequestInterface
{
    private ?string $actionId = null;

    /**
     * @var null|array<int, SceneComponentInterface>
     */
    private ?array $components = null;
    private ?string $deviceId = null;

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    /**
     * @return null|array<int, SceneComponentInterface>
     */
    public function getComponents(): ?array
    {
        return $this->components;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function setActionId(?string $value): SceneDeviceRequestInterface
    {
        $this->actionId = $value;

        return $this;
    }

    /**
     * @param null|array<int, SceneComponentInterface> $value
     */
    public function setComponents(?array $value): SceneDeviceRequestInterface
    {
        $this->components = $value;

        return $this;
    }

    public function setDeviceId(?string $value): SceneDeviceRequestInterface
    {
        $this->deviceId = $value;

        return $this;
    }
}
