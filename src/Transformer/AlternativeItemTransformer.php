<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItem;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;

use function is_string;
use function sprintf;

final class AlternativeItemTransformer implements AlternativeItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AlternativeItemInterface
    {
        $model = new AlternativeItem(self::requireKey($data), self::requireValue($data));

        self::applyType($model, $data);
        self::applyIconUrl($model, $data);
        self::applyDescription($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AlternativeItem $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(AlternativeItem $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyType(AlternativeItem $model, array $data): void
    {
        if (empty($data[self::KEY_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_TYPE])) {
            return;
        }
        $model->setType($data[self::KEY_TYPE]);
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
