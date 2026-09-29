<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\DeviceCategory;
use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;

use function is_string;
use function sprintf;

final class DeviceCategoryTransformer implements DeviceCategoryTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceCategoryInterface
    {
        $model = new DeviceCategory(self::requireName($data), self::requireCategoryType($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCategoryType(array $data): string
    {
        if (empty($data[self::KEY_CATEGORY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CATEGORY_TYPE));
        }
        if (!is_string($data[self::KEY_CATEGORY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_CATEGORY_TYPE));
        }

        return $data[self::KEY_CATEGORY_TYPE];
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
