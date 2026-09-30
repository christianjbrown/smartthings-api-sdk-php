<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StringConfig implements StringConfigInterface
{
    private ?string $value = null;

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): StringConfigInterface
    {
        $this->value = $value;

        return $this;
    }
}
