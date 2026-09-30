<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationCondition;
use ChristianBrown\SmartThings\Model\SliderForAutomationConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_numeric;
use function is_string;

final class SliderForAutomationConditionTransformer implements SliderForAutomationConditionTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SliderForAutomationConditionInterface
    {
        $model = new SliderForAutomationCondition(self::requireRange($data), self::requireValue($data));

        self::applyStep($model, $data);
        self::applyUnit($model, $data);
        self::applySupportedValues($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyValueType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(SliderForAutomationCondition $model, array $data): void
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
    private static function applyStep(SliderForAutomationCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_STEP])) {
            return;
        }
        if (!is_numeric($data[self::KEY_STEP])) {
            return;
        }
        $model->setStep((float) $data[self::KEY_STEP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(SliderForAutomationCondition $model, array $data): void
    {
        if (empty($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        if (!is_string($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        $model->setSupportedValues($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(SliderForAutomationCondition $model, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($data[self::KEY_UNIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(SliderForAutomationCondition $model, array $data): void
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
     *
     * @return mixed[]
     */
    private static function requireRange(array $data): array
    {
        if (!isset($data[self::KEY_RANGE])) {
            return [];
        }
        if (!is_array($data[self::KEY_RANGE])) {
            return [];
        }

        return $data[self::KEY_RANGE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
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
