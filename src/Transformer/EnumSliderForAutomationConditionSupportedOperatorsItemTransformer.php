<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItem;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

use function is_string;
use function sprintf;

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
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOperator(array $data): string
    {
        if (empty($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OPERATOR));
        }

        return $data[self::KEY_OPERATOR];
    }
}
