<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Subscription implements SubscriptionInterface
{
    private ?CapabilitySubscriptionDetailInterface $capability = null;
    private ?DeviceSubscriptionDetailInterface $device = null;
    private ?DeviceHealthDetailInterface $deviceHealth = null;
    private ?DeviceLifecycleDetailInterface $deviceLifecycle = null;
    private ?HubHealthDetailInterface $hubHealth = null;
    private string $id;
    private ?string $installedAppId = null;
    private ?ModeSubscriptionDetailInterface $mode = null;
    private ?SceneLifecycleDetailInterface $sceneLifecycle = null;
    private ?SecurityArmStateDetailInterface $securityArmState = null;
    private ?string $sourceType = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getCapability(): ?CapabilitySubscriptionDetailInterface
    {
        return $this->capability;
    }

    public function getDevice(): ?DeviceSubscriptionDetailInterface
    {
        return $this->device;
    }

    public function getDeviceHealth(): ?DeviceHealthDetailInterface
    {
        return $this->deviceHealth;
    }

    public function getDeviceLifecycle(): ?DeviceLifecycleDetailInterface
    {
        return $this->deviceLifecycle;
    }

    public function getHubHealth(): ?HubHealthDetailInterface
    {
        return $this->hubHealth;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getMode(): ?ModeSubscriptionDetailInterface
    {
        return $this->mode;
    }

    public function getSceneLifecycle(): ?SceneLifecycleDetailInterface
    {
        return $this->sceneLifecycle;
    }

    public function getSecurityArmState(): ?SecurityArmStateDetailInterface
    {
        return $this->securityArmState;
    }

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setCapability(?CapabilitySubscriptionDetailInterface $value): SubscriptionInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setDevice(?DeviceSubscriptionDetailInterface $value): SubscriptionInterface
    {
        $this->device = $value;

        return $this;
    }

    public function setDeviceHealth(?DeviceHealthDetailInterface $value): SubscriptionInterface
    {
        $this->deviceHealth = $value;

        return $this;
    }

    public function setDeviceLifecycle(?DeviceLifecycleDetailInterface $value): SubscriptionInterface
    {
        $this->deviceLifecycle = $value;

        return $this;
    }

    public function setHubHealth(?HubHealthDetailInterface $value): SubscriptionInterface
    {
        $this->hubHealth = $value;

        return $this;
    }

    public function setId(string $value): SubscriptionInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): SubscriptionInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setMode(?ModeSubscriptionDetailInterface $value): SubscriptionInterface
    {
        $this->mode = $value;

        return $this;
    }

    public function setSceneLifecycle(?SceneLifecycleDetailInterface $value): SubscriptionInterface
    {
        $this->sceneLifecycle = $value;

        return $this;
    }

    public function setSecurityArmState(?SecurityArmStateDetailInterface $value): SubscriptionInterface
    {
        $this->securityArmState = $value;

        return $this;
    }

    public function setSourceType(?string $value): SubscriptionInterface
    {
        $this->sourceType = $value;

        return $this;
    }
}
