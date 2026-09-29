<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Capability implements CapabilityInterface
{
    /**
     * @var array<array-key, CapabilityAttributeInterface>
     */
    private array $attributes = [];

    /**
     * @var array<array-key, CapabilityCommandInterface>
     */
    private array $commands = [];
    private ?bool $ephemeral = null;
    private string $id;
    private ?string $name = null;
    private ?string $status = null;
    private ?int $version = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    public function getEphemeral(): ?bool
    {
        return $this->ephemeral;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * @param array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(array $value): CapabilityInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(array $value): CapabilityInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setEphemeral(?bool $value): CapabilityInterface
    {
        $this->ephemeral = $value;

        return $this;
    }

    public function setId(string $value): CapabilityInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setName(?string $value): CapabilityInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setStatus(?string $value): CapabilityInterface
    {
        $this->status = $value;

        return $this;
    }

    public function setVersion(?int $value): CapabilityInterface
    {
        $this->version = $value;

        return $this;
    }
}
