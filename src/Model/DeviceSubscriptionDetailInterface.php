<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceSubscriptionDetailInterface
{
    public function getAttribute(): ?string;

    public function getCapability(): ?string;

    public function getComponentId(): ?string;

    public function getDeviceId(): string;

    /**
     * @return null|array<int, string>
     */
    public function getModes(): ?array;

    public function getStateChangeOnly(): ?bool;

    public function getSubscriptionName(): ?string;

    public function getValue(): mixed;

    public function setAttribute(?string $value): self;

    public function setCapability(?string $value): self;

    public function setComponentId(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setModes(?array $value): self;

    public function setStateChangeOnly(?bool $value): self;

    public function setSubscriptionName(?string $value): self;

    public function setValue(mixed $value): self;
}
