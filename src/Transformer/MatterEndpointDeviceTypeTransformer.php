<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpointDeviceType;
use ChristianBrown\SmartThings\Model\MatterEndpointDeviceTypeInterface;

use function is_numeric;

final class MatterEndpointDeviceTypeTransformer implements MatterEndpointDeviceTypeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterEndpointDeviceTypeInterface
    {
        $model = new MatterEndpointDeviceType();

        self::applyDeviceTypeId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDeviceTypeId(MatterEndpointDeviceType $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_TYPE_ID])) {
            return;
        }
        if (!is_numeric($data[self::KEY_DEVICE_TYPE_ID])) {
            return;
        }
        $model->setDeviceTypeId((float) $data[self::KEY_DEVICE_TYPE_ID]);
    }
}
