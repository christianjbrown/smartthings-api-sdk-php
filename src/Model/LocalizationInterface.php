<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocalizationInterface
{
    public function getDescription(): ?string;

    public function getLabel(): ?string;

    public function getTag(): string;

    public function setDescription(?string $value): self;

    public function setLabel(?string $value): self;

    public function setTag(string $value): self;
}
