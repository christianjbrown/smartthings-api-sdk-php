<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityArgumentI18n implements CapabilityArgumentI18nInterface
{
    private string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }
}
