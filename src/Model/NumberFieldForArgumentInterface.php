<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface NumberFieldForArgumentInterface
{
    public function getArgumentType(): ?string;

    public function getName(): string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function getSupportedValues(): ?string;

    public function getUnit(): ?string;

    public function setArgumentType(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;

    public function setSupportedValues(?string $value): self;

    public function setUnit(?string $value): self;
}
