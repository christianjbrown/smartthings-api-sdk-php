<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PoCodes;
use ChristianBrown\SmartThings\Model\PoCodesInterface;

use function is_string;
use function sprintf;

final class PoCodesTransformer implements PoCodesTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PoCodesInterface
    {
        $model = new PoCodes(self::requireLabel($data), self::requirePo($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }

    /**
     * @param mixed[] $data
     */
    private static function requirePo(array $data): string
    {
        if (empty($data[self::KEY_PO])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PO));
        }
        if (!is_string($data[self::KEY_PO])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_PO));
        }

        return $data[self::KEY_PO];
    }
}
