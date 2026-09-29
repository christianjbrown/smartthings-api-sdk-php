<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityReferenceRequestInterface
{
    public function getConfig(): ?CapabilityConfigurationInterface;

    public function getId(): string;

    public function getOptional(): ?bool;

    public function getRestrictions(): ?RestrictionInterface;

    public function getVersion(): ?int;

    public function setConfig(?CapabilityConfigurationInterface $value): self;

    public function setOptional(?bool $value): self;

    public function setRestrictions(?RestrictionInterface $value): self;

    public function setVersion(?int $value): self;
}
