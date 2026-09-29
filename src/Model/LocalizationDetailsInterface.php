<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocalizationDetailsInterface
{
    /**
     * @return null|array<array-key, CapabilityAttributeLocalizationInterface>
     */
    public function getAttributes(): ?array;

    /**
     * @return null|array<array-key, CapabilityCommandLocalizationInterface>
     */
    public function getCommands(): ?array;

    /**
     * @return null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): ?array;

    /**
     * @param null|array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(?array $value): self;

    /**
     * @param null|array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(?array $value): self;

    /**
     * @param null|array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(?array $value): self;
}
