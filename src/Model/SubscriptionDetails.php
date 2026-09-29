<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SubscriptionDetails implements SubscriptionDetailsInterface
{
    private ?CapabilitySubscriptionDetailInterface $capability = null;
    private ?DeviceSubscriptionDetailInterface $device = null;
    private ?DeviceHealthDetailInterface $deviceHealth = null;
    private ?DeviceLifecycleDetailInterface $deviceLifecycle = null;
    private ?HubHealthDetailInterface $hubHealth = null;
    private ?ModeSubscriptionDetailInterface $mode = null;
    private ?SceneLifecycleDetailInterface $sceneLifecycle = null;
    private ?SecurityArmStateDetailInterface $securityArmState = null;

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

    public function setCapability(?CapabilitySubscriptionDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setDevice(?DeviceSubscriptionDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->device = $value;

        return $this;
    }

    public function setDeviceHealth(?DeviceHealthDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->deviceHealth = $value;

        return $this;
    }

    public function setDeviceLifecycle(?DeviceLifecycleDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->deviceLifecycle = $value;

        return $this;
    }

    public function setHubHealth(?HubHealthDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->hubHealth = $value;

        return $this;
    }

    public function setMode(?ModeSubscriptionDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->mode = $value;

        return $this;
    }

    public function setSceneLifecycle(?SceneLifecycleDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->sceneLifecycle = $value;

        return $this;
    }

    public function setSecurityArmState(?SecurityArmStateDetailInterface $value): SubscriptionDetailsInterface
    {
        $this->securityArmState = $value;

        return $this;
    }
}
