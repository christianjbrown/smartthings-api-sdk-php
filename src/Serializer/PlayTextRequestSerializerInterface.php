<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayTextRequestInterface;

interface PlayTextRequestSerializerInterface
{
    public const string KEY_AUDIO_FORMAT = 'audioFormat';
    public const string KEY_DEVICE_ID = 'deviceId';
    public const string KEY_ENGINE = 'engine';
    public const string KEY_LANGUAGE_CODE = 'languageCode';
    public const string KEY_SPEAKING_STYLE = 'speakingStyle';
    public const string KEY_TEXT = 'text';
    public const string KEY_TTS_PROVIDER = 'ttsProvider';
    public const string KEY_VOICE_ID = 'voiceId';
    public const string KEY_VOLUME = 'volume';

    /**
     * @return mixed[]
     */
    public function serialize(PlayTextRequestInterface $request): array;
}
