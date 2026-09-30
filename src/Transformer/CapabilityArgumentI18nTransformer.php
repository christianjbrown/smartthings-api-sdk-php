<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityArgumentI18n;
use ChristianBrown\SmartThings\Model\CapabilityArgumentI18nInterface;

use function is_string;

final class CapabilityArgumentI18nTransformer implements CapabilityArgumentI18nTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityArgumentI18nInterface
    {
        $model = new CapabilityArgumentI18n(self::requireLabel($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): ?string
    {
        if (empty($data[self::KEY_LABEL])) {
            return null;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return null;
        }

        return $data[self::KEY_LABEL];
    }
}
