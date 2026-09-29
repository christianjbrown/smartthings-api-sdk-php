<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItem;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;

use function is_string;
use function sprintf;

final class TextButtonButtonsItemTransformer implements TextButtonButtonsItemTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextButtonButtonsItemInterface
    {
        $model = new TextButtonButtonsItem(self::requireKey($data), self::requireLabel($data));

        self::applyState($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyState(TextButtonButtonsItem $model, array $data): void
    {
        if (empty($data[self::KEY_STATE])) {
            return;
        }
        if (!is_string($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($data[self::KEY_STATE]);
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
}
