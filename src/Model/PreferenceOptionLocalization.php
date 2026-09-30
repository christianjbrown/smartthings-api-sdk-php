<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PreferenceOptionLocalization implements PreferenceOptionLocalizationInterface
{
    private ?string $label;

    public function __construct(?string $label)
    {
        $this->label = $label;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }
}
