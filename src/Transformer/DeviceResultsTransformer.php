<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceResults;
use ChristianBrown\SmartThings\Model\DeviceResultsInterface;

use function is_string;

final class DeviceResultsTransformer implements DeviceResultsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceResultsInterface
    {
        $model = new DeviceResults();

        self::applyDeviceId($model, $data);
        self::applyName($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceId(DeviceResults $model, array $data): void
    {
        if (empty($data[self::KEY_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_DEVICE_ID])) {
            return;
        }
        $model->setDeviceId($data[self::KEY_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyName(DeviceResults $model, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $model->setName($data[self::KEY_NAME]);
    }
}
