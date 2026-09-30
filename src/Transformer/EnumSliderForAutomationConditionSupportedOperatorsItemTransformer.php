<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItem;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

use function is_string;

final class EnumSliderForAutomationConditionSupportedOperatorsItemTransformer implements EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EnumSliderForAutomationConditionSupportedOperatorsItemInterface
    {
        $model = new EnumSliderForAutomationConditionSupportedOperatorsItem(self::requireOperator($data), self::requireLabel($data));

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

    /**
     * @param mixed[] $data
     */
    private static function requireOperator(array $data): ?string
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return null;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return null;
        }

        return $data[self::KEY_OPERATOR];
    }
}
