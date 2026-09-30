<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ConvertedTts;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConvertedTts::class)]
#[CoversClass(ConvertedTtsTransformer::class)]
final class ConvertedTtsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ConvertedTtsTransformerInterface::KEY_MESSAGE => 'test-message',
            ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 'test-audio-url',
        ];

        $transformer = new ConvertedTtsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-message', $actual->getMessage());
        self::assertSame('test-audio-url', $actual->getAudioUrl());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ConvertedTtsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'messageAbsent' => [[ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 'test-audio-url'], 'getMessage', null];
        yield 'messageWrongType' => [[ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 'test-audio-url', ConvertedTtsTransformerInterface::KEY_MESSAGE => 42], 'getMessage', null];
        yield 'audioUrlAbsent' => [[ConvertedTtsTransformerInterface::KEY_MESSAGE => 'test-message'], 'getAudioUrl', null];
        yield 'audioUrlWrongType' => [[ConvertedTtsTransformerInterface::KEY_MESSAGE => 'test-message', ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 42], 'getAudioUrl', null];
    }
}
