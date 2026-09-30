<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilitySubscriptionDetailInterface
{
    public function getAttribute(): ?string;

    public function getCapability(): ?string;

    public function getLocationId(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getModes(): ?array;

    public function getStateChangeOnly(): ?bool;

    public function getSubscriptionName(): ?string;

    public function getValue(): mixed;

    public function setAttribute(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setModes(?array $value): self;

    public function setStateChangeOnly(?bool $value): self;

    public function setSubscriptionName(?string $value): self;

    public function setValue(mixed $value): self;
}
