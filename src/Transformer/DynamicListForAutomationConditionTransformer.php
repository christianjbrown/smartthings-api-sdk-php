<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationCondition;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class DynamicListForAutomationConditionTransformer implements DynamicListForAutomationConditionTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private SupportedValuesForDynamicListTransformerInterface $supportedValuesForDynamicListTransformer;

    public function __construct(SupportedValuesForDynamicListTransformerInterface $supportedValuesForDynamicListTransformer, AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->supportedValuesForDynamicListTransformer = $supportedValuesForDynamicListTransformer;
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DynamicListForAutomationConditionInterface
    {
        $model = new DynamicListForAutomationCondition(self::requireValue($data), $this->requireSupportedValues($data));

        self::applyValueType($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyMultiSelectable($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(DynamicListForAutomationCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        $model->setAlternatives($this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMultiSelectable(DynamicListForAutomationCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_MULTI_SELECTABLE])) {
            return;
        }
        if (!is_bool($data[self::KEY_MULTI_SELECTABLE])) {
            return;
        }
        $model->setMultiSelectable($data[self::KEY_MULTI_SELECTABLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(DynamicListForAutomationCondition $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireSupportedValues(array $data): SupportedValuesForDynamicListInterface
    {
        if (!isset($data[self::KEY_SUPPORTED_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_SUPPORTED_VALUES));
        }
        if (!is_array($data[self::KEY_SUPPORTED_VALUES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_SUPPORTED_VALUES));
        }

        return $this->supportedValuesForDynamicListTransformer->transform($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): string
    {
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }

        return $data[self::KEY_VALUE];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
