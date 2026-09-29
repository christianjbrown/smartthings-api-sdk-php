<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityLocalizationRequest implements CapabilityLocalizationRequestInterface
{
    /**
     * @var null|array<array-key, CapabilityAttributeLocalizationInterface>
     */
    private ?array $attributes = null;

    /**
     * @var null|array<array-key, CapabilityCommandLocalizationInterface>
     */
    private ?array $commands = null;
    private ?string $description = null;
    private ?string $label = null;
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return null|array<array-key, CapabilityAttributeLocalizationInterface>
     */
    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    /**
     * @return null|array<array-key, CapabilityCommandLocalizationInterface>
     */
    public function getCommands(): ?array
    {
        return $this->commands;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param null|array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(?array $value): CapabilityLocalizationRequestInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(?array $value): CapabilityLocalizationRequestInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setDescription(?string $value): CapabilityLocalizationRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityLocalizationRequestInterface
    {
        $this->label = $value;

        return $this;
    }
}
