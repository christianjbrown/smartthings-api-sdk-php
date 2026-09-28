<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SubscriptionRequest implements SubscriptionRequestInterface
{
    private ?CapabilitySubscriptionDetailInterface $capability = null;
    private ?DeviceSubscriptionDetailInterface $device = null;
    private ?DeviceHealthDetailInterface $deviceHealth = null;
    private ?DeviceLifecycleDetailInterface $deviceLifecycle = null;
    private ?HubHealthDetailInterface $hubHealth = null;
    private ?ModeSubscriptionDetailInterface $mode = null;
    private ?SceneLifecycleDetailInterface $sceneLifecycle = null;
    private ?SecurityArmStateDetailInterface $securityArmState = null;
    private string $sourceType;

    public function __construct(string $sourceType)
    {
        $this->sourceType = $sourceType;
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

    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    public function setCapability(?CapabilitySubscriptionDetailInterface $value): SubscriptionRequestInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setDevice(?DeviceSubscriptionDetailInterface $value): SubscriptionRequestInterface
    {
        $this->device = $value;

        return $this;
    }

    public function setDeviceHealth(?DeviceHealthDetailInterface $value): SubscriptionRequestInterface
    {
        $this->deviceHealth = $value;

        return $this;
    }

    public function setDeviceLifecycle(?DeviceLifecycleDetailInterface $value): SubscriptionRequestInterface
    {
        $this->deviceLifecycle = $value;

        return $this;
    }

    public function setHubHealth(?HubHealthDetailInterface $value): SubscriptionRequestInterface
    {
        $this->hubHealth = $value;

        return $this;
    }

    public function setMode(?ModeSubscriptionDetailInterface $value): SubscriptionRequestInterface
    {
        $this->mode = $value;

        return $this;
    }

    public function setSceneLifecycle(?SceneLifecycleDetailInterface $value): SubscriptionRequestInterface
    {
        $this->sceneLifecycle = $value;

        return $this;
    }

    public function setSecurityArmState(?SecurityArmStateDetailInterface $value): SubscriptionRequestInterface
    {
        $this->securityArmState = $value;

        return $this;
    }
}
