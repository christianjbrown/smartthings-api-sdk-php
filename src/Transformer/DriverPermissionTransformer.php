<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DriverPermission;
use ChristianBrown\SmartThings\Model\DriverPermissionInterface;

use function is_array;
use function is_string;
use function sprintf;

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
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ATTRIBUTES));
        }
        if (!is_array($data[self::KEY_ATTRIBUTES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_ATTRIBUTES));
        }

        return $data[self::KEY_ATTRIBUTES];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireName(array $data): string
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }

        return $data[self::KEY_NAME];
    }
}
