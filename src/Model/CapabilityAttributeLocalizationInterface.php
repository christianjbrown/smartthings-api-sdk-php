<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityAttributeLocalizationInterface
{
    public function getDescription(): ?string;

    public function getDisplayTemplate(): ?string;

    /**
     * @return null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>>
     */
    public function getI18n(): ?array;

    public function getLabel(): ?string;

    public function setDescription(?string $value): self;

    public function setDisplayTemplate(?string $value): self;

    /**
     * @param null|array<array-key, array<array-key, CapabilityAttributeLabelInterface>> $value
     */
    public function setI18n(?array $value): self;

    public function setLabel(?string $value): self;
}
