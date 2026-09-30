<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItem;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItemInterface;

use function is_string;

final class EdgeDriverSupportedEndpointAppsAppsItemTransformer implements EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EdgeDriverSupportedEndpointAppsAppsItemInterface
    {
        $model = new EdgeDriverSupportedEndpointAppsAppsItem(self::requireAppName($data), self::requireVersion($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireAppName(array $data): ?string
    {
        if (empty($data[self::KEY_APP_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_APP_NAME])) {
            return null;
        }

        return $data[self::KEY_APP_NAME];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireVersion(array $data): ?string
    {
        if (empty($data[self::KEY_VERSION])) {
            return null;
        }
        if (!is_string($data[self::KEY_VERSION])) {
            return null;
        }

        return $data[self::KEY_VERSION];
    }
}
