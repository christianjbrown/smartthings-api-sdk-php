<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class LanguageItem implements LanguageItemInterface
{
    private ?string $locale;

    /**
     * @var array<int, PoCodesInterface>
     */
    private array $poCodes;

    /**
     * @phpstan-param array<int, PoCodesInterface> $poCodes
     */
    public function __construct(?string $locale, array $poCodes)
    {
        $this->locale = $locale;
        $this->poCodes = $poCodes;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    /**
     * @return array<int, PoCodesInterface>
     */
    public function getPoCodes(): array
    {
        return $this->poCodes;
    }
}
