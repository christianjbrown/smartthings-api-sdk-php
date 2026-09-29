<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PreferenceDefinitionInterface
{
    public function getDefaultValue(): mixed;

    public function getMaximum(): ?float;

    public function getMaxLength(): ?int;

    public function getMinimum(): ?float;

    public function getMinLength(): ?int;

    /**
     * @return null|array<array-key, string>
     */
    public function getOptions(): ?array;

    public function getStringType(): ?string;

    public function setDefaultValue(mixed $value): self;

    public function setMaximum(?float $value): self;

    public function setMaxLength(?int $value): self;

    public function setMinimum(?float $value): self;

    public function setMinLength(?int $value): self;

    /**
     * @param null|array<array-key, string> $value
     */
    public function setOptions(?array $value): self;

    public function setStringType(?string $value): self;
}
