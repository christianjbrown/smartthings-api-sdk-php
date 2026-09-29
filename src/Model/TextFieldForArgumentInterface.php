<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TextFieldForArgumentInterface
{
    public function getArgumentType(): ?string;

    public function getName(): string;

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array;

    public function setArgumentType(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): self;
}
