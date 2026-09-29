<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Owner;
use ChristianBrown\SmartThings\Model\OwnerInterface;

use function is_string;
use function sprintf;

final class OwnerTransformer implements OwnerTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): OwnerInterface
    {
        $model = new Owner(self::requireOwnerType($data), self::requireOwnerId($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOwnerId(array $data): string
    {
        if (empty($data[self::KEY_OWNER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OWNER_ID));
        }
        if (!is_string($data[self::KEY_OWNER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OWNER_ID));
        }

        return $data[self::KEY_OWNER_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOwnerType(array $data): string
    {
        if (empty($data[self::KEY_OWNER_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OWNER_TYPE));
        }
        if (!is_string($data[self::KEY_OWNER_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_OWNER_TYPE));
        }

        return $data[self::KEY_OWNER_TYPE];
    }
}
