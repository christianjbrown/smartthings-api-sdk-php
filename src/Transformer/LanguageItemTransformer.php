<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LanguageItem;
use ChristianBrown\SmartThings\Model\LanguageItemInterface;
use ChristianBrown\SmartThings\Model\PoCodesInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class LanguageItemTransformer implements LanguageItemTransformerInterface
{
    private PoCodesTransformerInterface $poCodesTransformer;

    public function __construct(PoCodesTransformerInterface $poCodesTransformer)
    {
        $this->poCodesTransformer = $poCodesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LanguageItemInterface
    {
        $model = new LanguageItem(self::requireLocale($data), $this->requirePoCodes($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLocale(array $data): ?string
    {
        if (empty($data[self::KEY_LOCALE])) {
            return null;
        }
        if (!is_string($data[self::KEY_LOCALE])) {
            return null;
        }

        return $data[self::KEY_LOCALE];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PoCodesInterface>
     */
    private function requirePoCodes(array $data): array
    {
        if (!isset($data[self::KEY_PO_CODES])) {
            return [];
        }
        if (!is_array($data[self::KEY_PO_CODES])) {
            return [];
        }

        return $this->transformListPoCodes($data[self::KEY_PO_CODES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, PoCodesInterface>
     */
    private function transformListPoCodes(array $data): array
    {
        return array_values(array_map(fn (array $item): PoCodesInterface => $this->poCodesTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
