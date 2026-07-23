<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LocaleReferenceInterface
{
    public function getTag(): string;

    public function setTag(string $value): self;
}
