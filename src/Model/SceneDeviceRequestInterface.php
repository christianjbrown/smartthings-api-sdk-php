<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneDeviceRequestInterface
{
    public function getActionId(): ?string;

    /**
     * @return null|array<int, SceneComponentInterface>
     */
    public function getComponents(): ?array;

    public function getDeviceId(): ?string;

    public function setActionId(?string $value): self;

    /**
     * @param null|array<int, SceneComponentInterface> $value
     */
    public function setComponents(?array $value): self;

    public function setDeviceId(?string $value): self;
}
