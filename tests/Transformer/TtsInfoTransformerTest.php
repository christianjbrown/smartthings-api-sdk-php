<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\TtsInfo;
use ChristianBrown\SmartThings\Model\TtsVoiceInterface;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformer;
use ChristianBrown\SmartThings\Transformer\TtsInfoTransformerInterface;
use ChristianBrown\SmartThings\Transformer\TtsVoiceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TtsInfo::class)]
#[CoversClass(TtsInfoTransformer::class)]
final class TtsInfoTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $ttsVoiceModel = self::createStub(TtsVoiceInterface::class);
        $ttsVoiceTransformer = self::createStub(TtsVoiceTransformerInterface::class);
        $ttsVoiceTransformer->method('transform')->willReturn($ttsVoiceModel);
        $data = [
            TtsInfoTransformerInterface::KEY_VOICES => [['test-nested']],
        ];

        $transformer = new TtsInfoTransformer($ttsVoiceTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$ttsVoiceModel], $actual->getVoices());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $ttsVoiceModel = self::createStub(TtsVoiceInterface::class);
        $ttsVoiceTransformer = self::createStub(TtsVoiceTransformerInterface::class);
        $ttsVoiceTransformer->method('transform')->willReturn($ttsVoiceModel);
        $transformer = new TtsInfoTransformer($ttsVoiceTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getVoices());
    }

    public function testTransformVoices(): void
    {
        $ttsVoiceModel = self::createStub(TtsVoiceInterface::class);
        $ttsVoiceTransformer = self::createStub(TtsVoiceTransformerInterface::class);
        $ttsVoiceTransformer->method('transform')->willReturn($ttsVoiceModel);
        $transformer = new TtsInfoTransformer($ttsVoiceTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getVoices());
        self::assertNull($transformer->transform($base + [TtsInfoTransformerInterface::KEY_VOICES => 'test-not-array'])->getVoices());
        self::assertSame([$ttsVoiceModel], $transformer->transform($base + [TtsInfoTransformerInterface::KEY_VOICES => [['test-nested'], 'test-skipped']])->getVoices());
    }
}
