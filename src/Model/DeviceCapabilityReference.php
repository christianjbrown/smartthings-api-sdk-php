<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceCapabilityReference implements DeviceCapabilityReferenceInterface
{
    private ?CapabilityConfigurationInterface $config = null;
    private ?bool $ephemeral = null;
    private string $id;
    private ?bool $optional = null;
    private ?RestrictionInterface $restrictions = null;

    /**
     * @var null|array<array-key, AttributeStateInterface>
     */
    private ?array $status = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getConfig(): ?CapabilityConfigurationInterface
    {
        return $this->config;
    }

    public function getEphemeral(): ?bool
    {
        return $this->ephemeral;
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

    /**
     * @return null|array<array-key, AttributeStateInterface>
     */
    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setConfig(?CapabilityConfigurationInterface $value): DeviceCapabilityReferenceInterface
    {
        $this->config = $value;

        return $this;
    }

    public function setEphemeral(?bool $value): DeviceCapabilityReferenceInterface
    {
        $this->ephemeral = $value;

        return $this;
    }

    public function setOptional(?bool $value): DeviceCapabilityReferenceInterface
    {
        $this->optional = $value;

        return $this;
    }

    public function setRestrictions(?RestrictionInterface $value): DeviceCapabilityReferenceInterface
    {
        $this->restrictions = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, AttributeStateInterface> $value
     */
    public function setStatus(?array $value): DeviceCapabilityReferenceInterface
    {
        $this->status = $value;

        return $this;
    }

    public function setVersion(?int $value): DeviceCapabilityReferenceInterface
    {
        $this->version = $value;

        return $this;
    }
}
