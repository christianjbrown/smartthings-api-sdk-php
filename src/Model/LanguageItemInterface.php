<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface LanguageItemInterface
{
    public function getLocale(): ?string;

    /**
     * @return array<int, PoCodesInterface>
     */
    public function getPoCodes(): array;
}
