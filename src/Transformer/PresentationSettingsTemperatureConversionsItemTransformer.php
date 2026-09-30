<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItem;
use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;

use function is_string;

final class PresentationSettingsTemperatureConversionsItemTransformer implements PresentationSettingsTemperatureConversionsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PresentationSettingsTemperatureConversionsItemInterface
    {
        $model = new PresentationSettingsTemperatureConversionsItem(self::requireValue($data));

        self::applyUnit($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyUnit(PresentationSettingsTemperatureConversionsItem $model, array $data): void
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
}
