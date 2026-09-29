<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceProfileComponentRequestInterface
{
    /**
     * @return array<int, CapabilityReferenceRequestInterface>
     */
    public function getCapabilities(): array;

    /**
     * @return array<int, DeviceCategoryInterface>
     */
    public function getCategories(): array;

    public function getId(): string;

    public function getLabel(): ?string;

    public function getOptional(): ?bool;

    public function getRestrictions(): ?RestrictionInterface;

    public function setLabel(?string $value): self;

    public function setOptional(?bool $value): self;

    public function setRestrictions(?RestrictionInterface $value): self;
}
