<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;
use function sprintf;

final class ExcludedConditionItemIdExcludeItemTransformer implements ExcludedConditionItemIdExcludeItemTransformerInterface
{
    private ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface $excludedConditionItemIdExcludeItemAttributesItemTransformer;

    public function __construct(ExcludedConditionItemIdExcludeItemAttributesItemTransformerInterface $excludedConditionItemIdExcludeItemAttributesItemTransformer)
    {
        $this->excludedConditionItemIdExcludeItemAttributesItemTransformer = $excludedConditionItemIdExcludeItemAttributesItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ExcludedConditionItemIdExcludeItemInterface
    {
        $model = new ExcludedConditionItemIdExcludeItem(self::requireCapability($data));

        self::applyComponent($model, $data);
        self::applyVersion($model, $data);
        $this->applyAttributes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAttributes(ExcludedConditionItemIdExcludeItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        if (!is_array($data[self::KEY_ATTRIBUTES])) {
            return;
        }
        $model->setAttributes($this->transformListExcludedConditionItemIdExcludeItemAttributesItem($data[self::KEY_ATTRIBUTES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(ExcludedConditionItemIdExcludeItem $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $model->setComponent($data[self::KEY_COMPONENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ExcludedConditionItemIdExcludeItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CAPABILITY));
        }

        return $data[self::KEY_CAPABILITY];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    private function transformListExcludedConditionItemIdExcludeItemAttributesItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedConditionItemIdExcludeItemAttributesItemInterface => $this->excludedConditionItemIdExcludeItemAttributesItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
