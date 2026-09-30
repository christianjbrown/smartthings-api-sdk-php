<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface NumberFieldInterface
{
    public function getArgumentType(): ?string;

    public function getCommand(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    public function setArgumentType(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;

    public function setValue(?string $value): self;

    public function setValueType(?string $value): self;
}
