<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityReferenceRequest implements CapabilityReferenceRequestInterface
{
    private ?CapabilityConfigurationInterface $config = null;
    private string $id;
    private ?bool $optional = null;
    private ?RestrictionInterface $restrictions = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getConfig(): ?CapabilityConfigurationInterface
    {
        return $this->config;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOptional(): ?bool
    {
        return $this->optional;
    }

    public function getRestrictions(): ?RestrictionInterface
    {
        return $this->restrictions;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setConfig(?CapabilityConfigurationInterface $value): CapabilityReferenceRequestInterface
    {
        $this->config = $value;

        return $this;
    }

    public function setOptional(?bool $value): CapabilityReferenceRequestInterface
    {
        $this->optional = $value;

        return $this;
    }

    public function setRestrictions(?RestrictionInterface $value): CapabilityReferenceRequestInterface
    {
        $this->restrictions = $value;

        return $this;
    }

    public function setVersion(?int $value): CapabilityReferenceRequestInterface
    {
        $this->version = $value;

        return $this;
    }
}
