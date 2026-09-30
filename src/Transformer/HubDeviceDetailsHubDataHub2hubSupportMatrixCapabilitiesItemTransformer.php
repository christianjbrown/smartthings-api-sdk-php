<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface;

use function is_int;
use function is_string;

final class HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer implements HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface
    {
        $model = new HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem(self::requireName($data), self::requireVersion($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireName(array $data): ?string
    {
        if (empty($data[self::KEY_NAME])) {
            return null;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return null;
        }

        return $data[self::KEY_NAME];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireVersion(array $data): ?int
    {
        if (!isset($data[self::KEY_VERSION])) {
            return null;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return null;
        }

        return $data[self::KEY_VERSION];
    }
}
