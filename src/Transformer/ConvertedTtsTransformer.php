<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ConvertedTts;
use ChristianBrown\SmartThings\Model\ConvertedTtsInterface;

use function is_string;
use function sprintf;

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
    private static function requireAudioUrl(array $data): string
    {
        if (empty($data[self::KEY_AUDIO_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_AUDIO_URL));
        }
        if (!is_string($data[self::KEY_AUDIO_URL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_AUDIO_URL));
        }

        return $data[self::KEY_AUDIO_URL];
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
