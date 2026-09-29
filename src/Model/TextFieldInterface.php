<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TextFieldInterface
{
    public function getArgumentType(): ?string;

    public function getCommand(): string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getValue(): ?string;

    public function getValueType(): ?string;

    public function setArgumentType(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setValue(?string $value): self;

    public function setValueType(?string $value): self;
}
