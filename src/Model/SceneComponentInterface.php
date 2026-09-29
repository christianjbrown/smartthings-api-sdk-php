<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneComponentInterface
{
    /**
     * @return null|array<int, SceneCapabilityInterface>
     */
    public function getCapabilities(): ?array;

    public function getComponentId(): ?string;

    /**
     * @param null|array<int, SceneCapabilityInterface> $value
     */
    public function setCapabilities(?array $value): self;

    public function setComponentId(?string $value): self;
}
