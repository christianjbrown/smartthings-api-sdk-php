<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceSubscriptionDetail implements DeviceSubscriptionDetailInterface
{
    private ?string $attribute = null;
    private ?string $capability = null;
    private ?string $componentId = null;
    private string $deviceId;

    /**
     * @var null|array<int, string>
     */
    private ?array $modes = null;
    private ?bool $stateChangeOnly = null;
    private ?string $subscriptionName = null;
    private mixed $value = null;

    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getComponentId(): ?string
    {
        return $this->componentId;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    /**
     * @return null|array<int, string>
     */
    public function getModes(): ?array
    {
        return $this->modes;
    }

    public function getStateChangeOnly(): ?bool
    {
        return $this->stateChangeOnly;
    }

    public function getSubscriptionName(): ?string
    {
        return $this->subscriptionName;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setAttribute(?string $value): DeviceSubscriptionDetailInterface
    {
        $this->attribute = $value;

        return $this;
    }

    public function setCapability(?string $value): DeviceSubscriptionDetailInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setComponentId(?string $value): DeviceSubscriptionDetailInterface
    {
        $this->componentId = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setModes(?array $value): DeviceSubscriptionDetailInterface
    {
        $this->modes = $value;

        return $this;
    }

    public function setStateChangeOnly(?bool $value): DeviceSubscriptionDetailInterface
    {
        $this->stateChangeOnly = $value;

        return $this;
    }

    public function setSubscriptionName(?string $value): DeviceSubscriptionDetailInterface
    {
        $this->subscriptionName = $value;

        return $this;
    }

    public function setValue(mixed $value): DeviceSubscriptionDetailInterface
    {
        $this->value = $value;

        return $this;
    }
}
