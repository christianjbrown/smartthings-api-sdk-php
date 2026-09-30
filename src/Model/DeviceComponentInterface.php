<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceComponentInterface
{
    /**
     * @return array<int, DeviceComponentCapabilityInterface>
     */
    public function getCapabilities(): array;

    /**
     * @return array<int, DeviceCategoryInterface>
     */
    public function getCategories(): array;

    public function getId(): ?string;

    public function getLabel(): ?string;

    public function getOptional(): ?bool;

    public function getRestrictions(): ?RestrictionInterface;

    /**
     * @param array<int, DeviceComponentCapabilityInterface> $value
     */
    public function setCapabilities(array $value): self;

    /**
     * @param array<int, DeviceCategoryInterface> $value
     */
    public function setCategories(array $value): self;

    public function setId(?string $value): self;

    public function setLabel(?string $value): self;

    public function setOptional(?bool $value): self;

    public function setRestrictions(?RestrictionInterface $value): self;
}
