<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItemInterface;

use function is_string;

final class DeviceConfigurationIconsItemProductKeysItemTransformer implements DeviceConfigurationIconsItemProductKeysItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationIconsItemProductKeysItemInterface
    {
        $model = new DeviceConfigurationIconsItemProductKeysItem(self::requireMnId($data), self::requireSetupId($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireMnId(array $data): ?string
    {
        if (empty($data[self::KEY_MN_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_MN_ID])) {
            return null;
        }

        return $data[self::KEY_MN_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireSetupId(array $data): ?string
    {
        if (empty($data[self::KEY_SETUP_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_SETUP_ID])) {
            return null;
        }

        return $data[self::KEY_SETUP_ID];
    }
}
