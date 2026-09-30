<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationValue;
use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_numeric;
use function is_string;

final class CapabilityConfigurationValueTransformer implements CapabilityConfigurationValueTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CapabilityConfigurationValueInterface
    {
        $model = new CapabilityConfigurationValue(self::requireKey($data));

        self::applyRange($model, $data);
        self::applyEnabledValues($model, $data);
        self::applyStep($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnabledValues(CapabilityConfigurationValue $model, array $data): void
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
    private static function applyRange(CapabilityConfigurationValue $model, array $data): void
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
    private static function applyStep(CapabilityConfigurationValue $model, array $data): void
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
     */
    private static function requireKey(array $data): ?string
    {
        if (empty($data[self::KEY_KEY])) {
            return null;
        }
        if (!is_string($data[self::KEY_KEY])) {
            return null;
        }

        return $data[self::KEY_KEY];
    }
}
