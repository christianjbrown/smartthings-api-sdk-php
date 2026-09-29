<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\TtsRequest;
use ChristianBrown\SmartThings\Serializer\TtsRequestSerializer;
use ChristianBrown\SmartThings\Serializer\TtsRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TtsRequest::class)]
#[CoversClass(TtsRequestSerializer::class)]
final class TtsRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new TtsRequest('test-text', 'test-language-code', 'test-voice-id');

        $serializer = new TtsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                TtsRequestSerializerInterface::KEY_TEXT => 'test-text',
                TtsRequestSerializerInterface::KEY_LANGUAGE_CODE => 'test-language-code',
                TtsRequestSerializerInterface::KEY_VOICE_ID => 'test-voice-id',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new TtsRequest('test-text', 'test-language-code', 'test-voice-id'))
            ->setAudioFormat('test-audio-format')
            ->setTtsProvider('test-tts-provider')
            ->setEngine('test-engine')
            ->setSpeakingStyle('test-speaking-style');

        $serializer = new TtsRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                TtsRequestSerializerInterface::KEY_TEXT => 'test-text',
                TtsRequestSerializerInterface::KEY_LANGUAGE_CODE => 'test-language-code',
                TtsRequestSerializerInterface::KEY_VOICE_ID => 'test-voice-id',
                TtsRequestSerializerInterface::KEY_AUDIO_FORMAT => 'test-audio-format',
                TtsRequestSerializerInterface::KEY_TTS_PROVIDER => 'test-tts-provider',
                TtsRequestSerializerInterface::KEY_ENGINE => 'test-engine',
                TtsRequestSerializerInterface::KEY_SPEAKING_STYLE => 'test-speaking-style',
            ],
            $actual
        );
    }
}
