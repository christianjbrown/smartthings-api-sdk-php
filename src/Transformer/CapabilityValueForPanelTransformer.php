<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\CapabilityValueForPanel;
use ChristianBrown\SmartThings\Model\CapabilityValueForPanelInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_numeric;
use function is_string;

final class CapabilityValueForPanelTransformer implements CapabilityValueForPanelTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityValueForPanelInterface
    {
        $model = new CapabilityValueForPanel();

        self::applyEnabledValues($model, $data);
        self::applyLabel($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyRange($model, $data);
        self::applyStep($model, $data);
        self::applyKey($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(CapabilityValueForPanel $model, array $data): void
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
    private static function applyEnabledValues(CapabilityValueForPanel $model, array $data): void
    {
        if (!isset($data[self::KEY_ENABLED_VALUES])) {
            return;
        }
        if (!is_array($data[self::KEY_ENABLED_VALUES])) {
            return;
        }
        $model->setEnabledValues(array_values(array_filter($data[self::KEY_ENABLED_VALUES], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyKey(CapabilityValueForPanel $model, array $data): void
    {
        if (empty($data[self::KEY_KEY])) {
            return;
        }
        if (!is_string($data[self::KEY_KEY])) {
            return;
        }
        $model->setKey($data[self::KEY_KEY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(CapabilityValueForPanel $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRange(CapabilityValueForPanel $model, array $data): void
    {
        if (!isset($data[self::KEY_RANGE])) {
            return;
        }
        if (!is_array($data[self::KEY_RANGE])) {
            return;
        }
        $model->setRange($data[self::KEY_RANGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStep(CapabilityValueForPanel $model, array $data): void
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
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
