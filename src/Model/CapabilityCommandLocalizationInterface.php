<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityCommandLocalizationInterface
{
    /**
     * @return null|array<array-key, CapabilityArgumentLocalizationInterface>
     */
    public function getArguments(): ?array;

    public function getDescription(): ?string;

    public function getLabel(): ?string;

    /**
     * @param null|array<array-key, CapabilityArgumentLocalizationInterface> $value
     */
    public function setArguments(?array $value): self;

    public function setDescription(?string $value): self;

    public function setLabel(?string $value): self;
}
