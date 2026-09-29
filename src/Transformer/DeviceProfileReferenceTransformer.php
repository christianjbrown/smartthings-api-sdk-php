<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceProfileReference;
use ChristianBrown\SmartThings\Model\DeviceProfileReferenceInterface;

use function is_string;

final class DeviceProfileReferenceTransformer implements DeviceProfileReferenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceProfileReferenceInterface
    {
        $model = new DeviceProfileReference();

        self::applyId($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(DeviceProfileReference $model, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }
}
