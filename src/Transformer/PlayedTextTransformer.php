<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PlayedText;
use ChristianBrown\SmartThings\Model\PlayedTextInterface;

use function is_string;

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
    private static function requireMessage(array $data): ?string
    {
        if (empty($data[self::KEY_MESSAGE])) {
            return null;
        }
        if (!is_string($data[self::KEY_MESSAGE])) {
            return null;
        }

        return $data[self::KEY_MESSAGE];
    }
}
