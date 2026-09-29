<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Localization implements LocalizationInterface
{
    /**
     * @var array<array-key, CapabilityAttributeLocalizationInterface>
     */
    private array $attributes = [];

    /**
     * @var array<array-key, CapabilityCommandLocalizationInterface>
     */
    private array $commands = [];
    private ?string $description = null;
    private ?string $label = null;

    /**
     * @var array<array-key, PreferenceOptionLocalizationInterface>
     */
    private array $options = [];
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return array<array-key, CapabilityAttributeLocalizationInterface>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<array-key, CapabilityCommandLocalizationInterface>
     */
    public function getCommands(): array
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

    /**
     * @return array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(array $value): LocalizationInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(array $value): LocalizationInterface
    {
        $this->commands = $value;

        return $this;
    }

    public function setDescription(?string $value): LocalizationInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setLabel(?string $value): LocalizationInterface
    {
        $this->label = $value;

        return $this;
    }

    /**
     * @param array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(array $value): LocalizationInterface
    {
        $this->options = $value;

        return $this;
    }

    public function setTag(string $value): LocalizationInterface
    {
        $this->tag = $value;

        return $this;
    }
}
