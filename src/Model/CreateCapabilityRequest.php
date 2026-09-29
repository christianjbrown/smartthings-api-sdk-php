<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateCapabilityRequest implements CreateCapabilityRequestInterface
{
    /**
     * @var null|array<array-key, CapabilityAttributeInterface>
     */
    private ?array $attributes = null;

    /**
     * @var null|array<array-key, CapabilityCommandInterface>
     */
    private ?array $commands = null;
    private ?bool $ephemeral = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|array<array-key, CapabilityAttributeInterface>
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return null|array<array-key, CapabilityCommandInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
    }

    public function getEphemeral(): ?bool
    {
        return $this->ephemeral;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param null|array<array-key, CapabilityAttributeInterface> $value
     */
    public function setAttributes(?array $value): CreateCapabilityRequestInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, CapabilityCommandInterface> $value
     */
    public function setCommands(?array $value): CreateCapabilityRequestInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setEphemeral(?bool $value): CreateCapabilityRequestInterface
    {
        $this->ephemeral = $value;

        return $this;
    }
}
