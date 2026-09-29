<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TtsVoice;
use ChristianBrown\SmartThings\Model\TtsVoiceInterface;

use function array_filter;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class TtsVoiceTransformer implements TtsVoiceTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TtsVoiceInterface
    {
        $model = new TtsVoice(self::requireGender($data), self::requireId($data), self::requireLanguageCode($data), self::requireLanguageName($data), self::requireName($data), self::requireTtsProvider($data));

        self::applySupportedEngines($model, $data);
        self::applySpeakingStyle($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySpeakingStyle(TtsVoice $model, array $data): void
    {
        if (!isset($data[self::KEY_SPEAKING_STYLE])) {
            return;
        }
        if (!is_array($data[self::KEY_SPEAKING_STYLE])) {
            return;
        }
        $model->setSpeakingStyle(array_values(array_filter($data[self::KEY_SPEAKING_STYLE], is_string(...))));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedEngines(TtsVoice $model, array $data): void
    {
        if (!isset($data[self::KEY_SUPPORTED_ENGINES])) {
            return;
        }
        if (!is_array($data[self::KEY_SUPPORTED_ENGINES])) {
            return;
        }
        $model->setSupportedEngines(array_values(array_filter($data[self::KEY_SUPPORTED_ENGINES], is_string(...))));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireGender(array $data): string
    {
        if (empty($data[self::KEY_GENDER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_GENDER));
        }
        if (!is_string($data[self::KEY_GENDER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_GENDER));
        }

        return $data[self::KEY_GENDER];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireId(array $data): string
    {
        if (empty($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }
        if (!is_string($data[self::KEY_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_ID));
        }

        return $data[self::KEY_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLanguageCode(array $data): string
    {
        if (empty($data[self::KEY_LANGUAGE_CODE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LANGUAGE_CODE));
        }
        if (!is_string($data[self::KEY_LANGUAGE_CODE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LANGUAGE_CODE));
        }

        return $data[self::KEY_LANGUAGE_CODE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLanguageName(array $data): string
    {
        if (empty($data[self::KEY_LANGUAGE_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LANGUAGE_NAME));
        }
        if (!is_string($data[self::KEY_LANGUAGE_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LANGUAGE_NAME));
        }

        return $data[self::KEY_LANGUAGE_NAME];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireName(array $data): string
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }

        return $data[self::KEY_NAME];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireTtsProvider(array $data): string
    {
        if (empty($data[self::KEY_TTSPROVIDER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TTSPROVIDER));
        }
        if (!is_string($data[self::KEY_TTSPROVIDER])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_TTSPROVIDER));
        }

        return $data[self::KEY_TTSPROVIDER];
    }
}
