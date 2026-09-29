<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceCapabilityReferenceInterface
{
    public function getConfig(): ?CapabilityConfigurationInterface;

    public function getEphemeral(): ?bool;

    public function getId(): string;

    public function getOptional(): ?bool;

    public function getRestrictions(): ?RestrictionInterface;

    /**
     * @return null|array<array-key, AttributeStateInterface>
     */
    public function getStatus(): ?array;

    public function getVersion(): ?int;

    public function setConfig(?CapabilityConfigurationInterface $value): self;

    public function setEphemeral(?bool $value): self;

    public function setOptional(?bool $value): self;

    public function setRestrictions(?RestrictionInterface $value): self;

    /**
     * @param null|array<array-key, AttributeStateInterface> $value
     */
    public function setStatus(?array $value): self;

    public function setVersion(?int $value): self;
}
