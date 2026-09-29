<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PlayTextRequest;
use ChristianBrown\SmartThings\Serializer\PlayTextRequestSerializer;
use ChristianBrown\SmartThings\Serializer\PlayTextRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PlayTextRequest::class)]
#[CoversClass(PlayTextRequestSerializer::class)]
final class PlayTextRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new PlayTextRequest('test-device-id', 'test-text', 'test-language-code', 'test-voice-id');

        $serializer = new PlayTextRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PlayTextRequestSerializerInterface::KEY_DEVICE_ID => 'test-device-id',
                PlayTextRequestSerializerInterface::KEY_TEXT => 'test-text',
                PlayTextRequestSerializerInterface::KEY_LANGUAGE_CODE => 'test-language-code',
                PlayTextRequestSerializerInterface::KEY_VOICE_ID => 'test-voice-id',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new PlayTextRequest('test-device-id', 'test-text', 'test-language-code', 'test-voice-id'))
            ->setAudioFormat('test-audio-format')
            ->setTtsProvider('test-tts-provider')
            ->setEngine('test-engine')
            ->setSpeakingStyle('test-speaking-style')
            ->setVolume(7);

        $serializer = new PlayTextRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                PlayTextRequestSerializerInterface::KEY_DEVICE_ID => 'test-device-id',
                PlayTextRequestSerializerInterface::KEY_TEXT => 'test-text',
                PlayTextRequestSerializerInterface::KEY_LANGUAGE_CODE => 'test-language-code',
                PlayTextRequestSerializerInterface::KEY_VOICE_ID => 'test-voice-id',
                PlayTextRequestSerializerInterface::KEY_AUDIO_FORMAT => 'test-audio-format',
                PlayTextRequestSerializerInterface::KEY_TTS_PROVIDER => 'test-tts-provider',
                PlayTextRequestSerializerInterface::KEY_ENGINE => 'test-engine',
                PlayTextRequestSerializerInterface::KEY_SPEAKING_STYLE => 'test-speaking-style',
                PlayTextRequestSerializerInterface::KEY_VOLUME => 7,
            ],
            $actual
        );
    }
}
