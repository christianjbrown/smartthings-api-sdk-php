<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LocaleReference implements LocaleReferenceInterface
{
    private string $tag;

    public function __construct(string $tag)
    {
        $this->tag = $tag;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function setTag(string $value): LocaleReferenceInterface
    {
        $this->tag = $value;

        return $this;
    }
}
