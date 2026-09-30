<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;

use function is_string;

final class DeviceConfigurationDpInfoItemArgumentsItemTransformer implements DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDpInfoItemArgumentsItemInterface
    {
        $model = new DeviceConfigurationDpInfoItemArgumentsItem(self::requireKey($data), self::requireValue($data));

        return $model;
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
