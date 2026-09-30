<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class ExcludedConditionItemTransformer implements ExcludedConditionItemTransformerInterface
{
    private ExcludedConditionItemIdExcludeItemTransformerInterface $excludedConditionItemIdExcludeItemTransformer;

    public function __construct(ExcludedConditionItemIdExcludeItemTransformerInterface $excludedConditionItemIdExcludeItemTransformer)
    {
        $this->excludedConditionItemIdExcludeItemTransformer = $excludedConditionItemIdExcludeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedConditionItemInterface
    {
        $model = new ExcludedConditionItem($this->requireExclude($data));

        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ExcludedConditionItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_array($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    private function requireExclude(array $data): array
    {
        if (!isset($data[self::KEY_EXCLUDE])) {
            return [];
        }
        if (!is_array($data[self::KEY_EXCLUDE])) {
            return [];
        }

        return $this->transformListExcludedConditionItemIdExcludeItem($data[self::KEY_EXCLUDE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    private function transformListExcludedConditionItemIdExcludeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedConditionItemIdExcludeItemInterface => $this->excludedConditionItemIdExcludeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
