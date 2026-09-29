<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityLocalizationRequestInterface
{
    /**
     * @return null|array<array-key, CapabilityAttributeLocalizationInterface>
     */
    public function getAttributes(): ?array;

    /**
     * @return null|array<array-key, CapabilityCommandLocalizationInterface>
     */
    public function getCommands(): ?array;

    public function getDescription(): ?string;

    public function getLabel(): ?string;

    public function getTag(): string;

    /**
     * @param null|array<array-key, CapabilityAttributeLocalizationInterface> $value
     */
    public function setAttributes(?array $value): self;

    /**
     * @param null|array<array-key, CapabilityCommandLocalizationInterface> $value
     */
    public function setCommands(?array $value): self;

    public function setDescription(?string $value): self;

    public function setLabel(?string $value): self;
}
