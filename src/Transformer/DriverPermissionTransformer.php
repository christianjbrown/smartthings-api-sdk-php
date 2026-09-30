<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DriverPermission;
use ChristianBrown\SmartThings\Model\DriverPermissionInterface;

use function is_array;
use function is_string;

final class DriverPermissionTransformer implements DriverPermissionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DriverPermissionInterface
    {
        $model = new DriverPermission(self::requireName($data), self::requireAttributes($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    private static function requireAttributes(array $data): array
    {
        if (!isset($data[self::KEY_ATTRIBUTES])) {
            return [];
        }
        if (!is_array($data[self::KEY_ATTRIBUTES])) {
            return [];
        }

        return $data[self::KEY_ATTRIBUTES];
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
}
