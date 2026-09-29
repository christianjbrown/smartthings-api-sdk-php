<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TtsRequestInterface;

interface TtsRequestSerializerInterface
{
    public const string KEY_AUDIO_FORMAT = 'audioFormat';
    public const string KEY_ENGINE = 'engine';
    public const string KEY_LANGUAGE_CODE = 'languageCode';
    public const string KEY_SPEAKING_STYLE = 'speakingStyle';
    public const string KEY_TEXT = 'text';
    public const string KEY_TTS_PROVIDER = 'ttsProvider';
    public const string KEY_VOICE_ID = 'voiceId';

    /**
     * @return mixed[]
     */
    public function serialize(TtsRequestInterface $request): array;
}
