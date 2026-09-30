<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationAction;
use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_numeric;
use function is_string;

final class SliderForAutomationActionTransformer implements SliderForAutomationActionTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SliderForAutomationActionInterface
    {
        $model = new SliderForAutomationAction(self::requireRange($data), self::requireCommand($data));

        self::applyStep($model, $data);
        self::applyUnit($model, $data);
        self::applySupportedValues($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyArgumentType($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(SliderForAutomationAction $model, array $data): void
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
    private static function applyArgumentType(SliderForAutomationAction $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        $model->setArgumentType($data[self::KEY_ARGUMENT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStep(SliderForAutomationAction $model, array $data): void
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
    private static function applySupportedValues(SliderForAutomationAction $model, array $data): void
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
    private static function applyUnit(SliderForAutomationAction $model, array $data): void
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
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
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
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
