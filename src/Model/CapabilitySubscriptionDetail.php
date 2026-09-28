<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilitySubscriptionDetail implements CapabilitySubscriptionDetailInterface
{
    private ?string $attribute = null;
    private string $capability;
    private string $locationId;

    /**
     * @var null|array<int, string>
     */
    private ?array $modes = null;
    private ?bool $stateChangeOnly = null;
    private ?string $subscriptionName = null;
    private mixed $value = null;

    public function __construct(string $locationId, string $capability)
    {
        $this->locationId = $locationId;
        $this->capability = $capability;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getCapability(): string
    {
        return $this->capability;
    }

    public function getLocationId(): string
    {
        return $this->locationId;
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

    public function setAttribute(?string $value): CapabilitySubscriptionDetailInterface
    {
        $this->attribute = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setModes(?array $value): CapabilitySubscriptionDetailInterface
    {
        $this->modes = $value;

        return $this;
    }

    public function setStateChangeOnly(?bool $value): CapabilitySubscriptionDetailInterface
    {
        $this->stateChangeOnly = $value;

        return $this;
    }

    public function setSubscriptionName(?string $value): CapabilitySubscriptionDetailInterface
    {
        $this->subscriptionName = $value;

        return $this;
    }

    public function setValue(mixed $value): CapabilitySubscriptionDetailInterface
    {
        $this->value = $value;

        return $this;
    }
}
