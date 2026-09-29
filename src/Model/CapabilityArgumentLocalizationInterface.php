<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityArgumentLocalizationInterface
{
    public function getDescription(): ?string;

    /**
     * @return null|array<array-key, CapabilityArgumentI18nInterface>
     */
    public function getI18n(): ?array;

    public function getLabel(): ?string;

    public function setDescription(?string $value): self;

    /**
     * @param null|array<array-key, CapabilityArgumentI18nInterface> $value
     */
    public function setI18n(?array $value): self;

    public function setLabel(?string $value): self;
}
