<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocalizationInterface
{
    /**
     * @return array<array-key, CapabilityAttributeLocalizationInterface>
     */
    public function getAttributes(): array;

    /**
     * @return array<array-key, CapabilityCommandLocalizationInterface>
     */
    public function getCommands(): array;

    public function getDescription(): ?string;

    public function getLabel(): ?string;

    /**
     * @return array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): array;

    public function getTag(): string;

    /**
     * @param array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(array $value): self;

    /**
     * @param array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(array $value): self;

    public function setDescription(?string $value): self;

    public function setLabel(?string $value): self;

    /**
     * @param array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(array $value): self;

    public function setTag(string $value): self;
}
