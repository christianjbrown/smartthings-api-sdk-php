<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TextButtonInterface
{
    /**
     * @return array<int, TextButtonButtonsItemInterface>
     */
    public function getButtons(): array;

    public function getCommand(): ?string;

    public function getSupportedValues(): ?string;

    public function getValue(): ?string;

    public function setCommand(?string $value): self;

    public function setSupportedValues(?string $value): self;

    public function setValue(?string $value): self;
}
