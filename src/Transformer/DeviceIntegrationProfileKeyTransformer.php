<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKey;
use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;

use function is_int;
use function is_string;

final class DeviceIntegrationProfileKeyTransformer implements DeviceIntegrationProfileKeyTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceIntegrationProfileKeyInterface
    {
        $model = new DeviceIntegrationProfileKey();

        self::applyId($model, $data);
        self::applyMajorVersion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyId(DeviceIntegrationProfileKey $model, array $data): void
    {
        if (empty($data[self::KEY_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ID])) {
            return;
        }
        $model->setId($data[self::KEY_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMajorVersion(DeviceIntegrationProfileKey $model, array $data): void
    {
        if (!isset($data[self::KEY_MAJOR_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_MAJOR_VERSION])) {
            return;
        }
        $model->setMajorVersion($data[self::KEY_MAJOR_VERSION]);
    }
}
