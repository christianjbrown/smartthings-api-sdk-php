<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemId;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;

final class ExcludedConditionItemIdTransformer implements ExcludedConditionItemIdTransformerInterface
{
    private ExcludedConditionItemIdExcludeItemTransformerInterface $excludedConditionItemIdExcludeItemTransformer;

    public function __construct(ExcludedConditionItemIdExcludeItemTransformerInterface $excludedConditionItemIdExcludeItemTransformer)
    {
        $this->excludedConditionItemIdExcludeItemTransformer = $excludedConditionItemIdExcludeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedConditionItemIdInterface
    {
        $model = new ExcludedConditionItemId($this->requireExclude($data));

        self::applyId($model, $data);
        self::applyValue($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(ExcludedConditionItemId $model, array $data): void
    {
        if (!isset($data[self::KEY_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(ExcludedConditionItemId $model, array $data): void
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
