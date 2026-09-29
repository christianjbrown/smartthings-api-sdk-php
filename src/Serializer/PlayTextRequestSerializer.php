<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayTextRequestInterface;

use function array_filter;

final class PlayTextRequestSerializer implements PlayTextRequestSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PlayTextRequestInterface $request): array
    {
        return self::filter([
            self::KEY_DEVICE_ID => $request->getDeviceId(),
            self::KEY_TEXT => $request->getText(),
            self::KEY_LANGUAGE_CODE => $request->getLanguageCode(),
            self::KEY_VOICE_ID => $request->getVoiceId(),
            self::KEY_AUDIO_FORMAT => $request->getAudioFormat(),
            self::KEY_TTS_PROVIDER => $request->getTtsProvider(),
            self::KEY_ENGINE => $request->getEngine(),
            self::KEY_SPEAKING_STYLE => $request->getSpeakingStyle(),
            self::KEY_VOLUME => $request->getVolume(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
