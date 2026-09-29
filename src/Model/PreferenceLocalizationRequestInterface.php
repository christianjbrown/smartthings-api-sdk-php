<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PreferenceLocalizationRequestInterface
{
    public function getDescription(): ?string;

    public function getLabel(): string;

    /**
     * @return null|array<array-key, PreferenceOptionLocalizationInterface>
     */
    public function getOptions(): ?array;

    public function getTag(): string;

    public function setDescription(?string $value): self;

    /**
     * @param null|array<array-key, PreferenceOptionLocalizationInterface> $value
     */
    public function setOptions(?array $value): self;
}
