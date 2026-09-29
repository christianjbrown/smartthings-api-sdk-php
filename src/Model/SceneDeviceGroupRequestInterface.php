<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneDeviceGroupRequestInterface
{
    public function getActionId(): ?string;

    public function getCapability(): ?SceneCapabilityInterface;

    public function getDeviceGroupId(): string;

    public function setActionId(?string $value): self;

    public function setCapability(?SceneCapabilityInterface $value): self;
}
