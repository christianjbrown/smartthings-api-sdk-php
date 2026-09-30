<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;

final class ExcludedConditionItemIdExcludeItemAttributesItemTransformer implements ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedConditionItemIdExcludeItemAttributesItemInterface
    {
        $model = new ExcludedConditionItemIdExcludeItemAttributesItem(self::requireName($data));

        self::applyExcludedValues($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyExcludedValues(ExcludedConditionItemIdExcludeItemAttributesItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EXCLUDED_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_EXCLUDED_VALUES])) {
            return;
        }
        $model->setExcludedValues(array_values(array_filter($data[self::KEY_EXCLUDED_VALUES], is_string(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireName(array $data): ?string
    {
        if (empty($data[self::KEY_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return null;
        }

        return $data[self::KEY_NAME];
    }
}
