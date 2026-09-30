<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PreferenceOptionLocalization;
use ChristianBrown\SmartThings\Model\PreferenceOptionLocalizationInterface;

use function is_string;

final class PreferenceOptionLocalizationTransformer implements PreferenceOptionLocalizationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PreferenceOptionLocalizationInterface
    {
        $model = new PreferenceOptionLocalization(self::requireLabel($data));

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
