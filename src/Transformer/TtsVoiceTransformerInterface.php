<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TtsVoiceInterface;

interface TtsVoiceTransformerInterface
{
    public const string KEY_GENDER = 'Gender';
    public const string KEY_ID = 'Id';
    public const string KEY_LANGUAGE_CODE = 'LanguageCode';
    public const string KEY_LANGUAGE_NAME = 'LanguageName';
    public const string KEY_NAME = 'Name';
    public const string KEY_SPEAKING_STYLE = 'SpeakingStyle';
    public const string KEY_SUPPORTED_ENGINES = 'SupportedEngines';
    public const string KEY_TTSPROVIDER = 'TTSProvider';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TtsVoiceInterface;
}
