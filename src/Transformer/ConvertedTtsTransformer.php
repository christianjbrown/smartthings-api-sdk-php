<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ConvertedTts;
use ChristianBrown\SmartThings\Model\ConvertedTtsInterface;

use function is_string;

final class ConvertedTtsTransformer implements ConvertedTtsTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ConvertedTtsInterface
    {
        $model = new ConvertedTts(self::requireMessage($data), self::requireAudioUrl($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireAudioUrl(array $data): ?string
    {
        if (empty($data[self::KEY_AUDIO_URL])) {
            return null;
        }
        if (!is_string($data[self::KEY_AUDIO_URL])) {
            return null;
        }

        return $data[self::KEY_AUDIO_URL];
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
