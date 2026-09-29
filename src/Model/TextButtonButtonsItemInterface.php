<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TextButtonButtonsItemInterface
{
    public function getKey(): string;

    public function getLabel(): string;

    public function getState(): ?string;

    public function setState(?string $value): self;
}
