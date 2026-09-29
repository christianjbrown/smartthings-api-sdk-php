<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SubscriptionInterface
{
    public function getCapability(): ?CapabilitySubscriptionDetailInterface;

    public function getDevice(): ?DeviceSubscriptionDetailInterface;

    public function getDeviceHealth(): ?DeviceHealthDetailInterface;

    public function getDeviceLifecycle(): ?DeviceLifecycleDetailInterface;

    public function getHubHealth(): ?HubHealthDetailInterface;

    public function getId(): string;

    public function getInstalledAppId(): ?string;

    public function getMode(): ?ModeSubscriptionDetailInterface;

    public function getSceneLifecycle(): ?SceneLifecycleDetailInterface;

    public function getSecurityArmState(): ?SecurityArmStateDetailInterface;

    public function getSourceType(): ?string;

    public function setCapability(?CapabilitySubscriptionDetailInterface $value): self;

    public function setDevice(?DeviceSubscriptionDetailInterface $value): self;

    public function setDeviceHealth(?DeviceHealthDetailInterface $value): self;

    public function setDeviceLifecycle(?DeviceLifecycleDetailInterface $value): self;

    public function setHubHealth(?HubHealthDetailInterface $value): self;

    public function setId(string $value): self;

    public function setInstalledAppId(?string $value): self;

    public function setMode(?ModeSubscriptionDetailInterface $value): self;

    public function setSceneLifecycle(?SceneLifecycleDetailInterface $value): self;

    public function setSecurityArmState(?SecurityArmStateDetailInterface $value): self;

    public function setSourceType(?string $value): self;
}
