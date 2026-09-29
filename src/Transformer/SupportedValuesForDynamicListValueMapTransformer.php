<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMap;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;

use function is_string;
use function sprintf;

final class SupportedValuesForDynamicListValueMapTransformer implements SupportedValuesForDynamicListValueMapTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): SupportedValuesForDynamicListValueMapInterface
    {
        $model = new SupportedValuesForDynamicListValueMap(self::requireKey($data), self::requireValue($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireKey(array $data): string
    {
        if (empty($data[self::KEY_KEY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_KEY));
        }
        if (!is_string($data[self::KEY_KEY])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_KEY));
        }

        return $data[self::KEY_KEY];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): string
    {
        if (empty($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }
        if (!is_string($data[self::KEY_VALUE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_VALUE));
        }

        return $data[self::KEY_VALUE];
    }
}
