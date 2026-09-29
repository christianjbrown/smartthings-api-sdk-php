<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationCondition;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class EnumSliderForAutomationConditionTransformer implements EnumSliderForAutomationConditionTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface $enumSliderForAutomationConditionSupportedOperatorsItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer, EnumSliderForAutomationConditionSupportedOperatorsItemTransformerInterface $enumSliderForAutomationConditionSupportedOperatorsItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
        $this->enumSliderForAutomationConditionSupportedOperatorsItemTransformer = $enumSliderForAutomationConditionSupportedOperatorsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EnumSliderForAutomationConditionInterface
    {
        $model = new EnumSliderForAutomationCondition($this->requireAlternatives($data), self::requireValue($data));

        $this->applySupportedOperators($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySupportedOperators(EnumSliderForAutomationCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_SUPPORTED_OPERATORS])) {
            return;
        }
        if (!is_array($data[self::KEY_SUPPORTED_OPERATORS])) {
            return;
        }
        $model->setSupportedOperators($this->transformListEnumSliderForAutomationConditionSupportedOperatorsItem($data[self::KEY_SUPPORTED_OPERATORS]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function requireAlternatives(array $data): array
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ALTERNATIVES));
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ALTERNATIVES));
        }

        return $this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]);
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

    /**
     * @param mixed[] $data
     *
     * @return array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface>
     */
    private function transformListEnumSliderForAutomationConditionSupportedOperatorsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): EnumSliderForAutomationConditionSupportedOperatorsItemInterface => $this->enumSliderForAutomationConditionSupportedOperatorsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
