<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SceneComponent implements SceneComponentInterface
{
    /**
     * @var null|array<int, SceneCapabilityInterface>
     */
    private ?array $capabilities = null;
    private ?string $componentId = null;

    /**
     * @return null|array<int, SceneCapabilityInterface>
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    public function getComponentId(): ?string
    {
        return $this->componentId;
    }

    /**
     * @param null|array<int, SceneCapabilityInterface> $value
     */
    public function setCapabilities(?array $value): SceneComponentInterface
    {
        $this->capabilities = $value;

        return $this;
    }

    public function setComponentId(?string $value): SceneComponentInterface
    {
        $this->componentId = $value;

        return $this;
    }
}
