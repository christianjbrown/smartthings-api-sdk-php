<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocaleReference;
use ChristianBrown\SmartThings\Model\LocaleReferenceInterface;

use function is_string;
use function sprintf;

final class LocaleReferenceTransformer implements LocaleReferenceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocaleReferenceInterface
    {
        if (empty($data[self::KEY_TAG])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TAG));
        }
        if (!is_string($data[self::KEY_TAG])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TAG));
        }

        return new LocaleReference($data[self::KEY_TAG]);
    }
}
