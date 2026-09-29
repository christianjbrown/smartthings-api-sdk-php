<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocalizationDetails implements LocalizationDetailsInterface
{
    /**
     * @var null|array<array-key, CapabilityAttributeLocalizationInterface>
     */
    private ?array $attributes = null;

    /**
     * @var null|array<array-key, CapabilityCommandLocalizationInterface>
     */
    private ?array $commands = null;

    /**
     * @var null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    private ?array $options = null;

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

    /**
     * @return null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @param null|array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(?array $value): LocalizationDetailsInterface
    {
        $this->attributes = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(?array $value): LocalizationDetailsInterface
    {
        $this->commands = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(?array $value): LocalizationDetailsInterface
    {
        $this->options = $value;

        return $this;
    }
}
