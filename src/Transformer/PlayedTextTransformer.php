<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayedText;
use ChristianBrown\SmartThings\Model\PlayedTextInterface;

use function is_string;
use function sprintf;

final class PlayedTextTransformer implements PlayedTextTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PlayedTextInterface
    {
        $model = new PlayedText(self::requireMessage($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireMessage(array $data): string
    {
        if (empty($data[self::KEY_MESSAGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MESSAGE));
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_MESSAGE));
        }

        return $data[self::KEY_MESSAGE];
    }
}
