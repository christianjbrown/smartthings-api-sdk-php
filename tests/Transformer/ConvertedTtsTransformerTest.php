<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ConvertedTts;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformer;
use ChristianBrown\SmartThings\Transformer\ConvertedTtsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ConvertedTtsTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'messageAbsent' => [[ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 'test-audio-url'], sprintf(ConvertedTtsTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedTtsTransformerInterface::KEY_MESSAGE)];
        yield 'messageWrongType' => [[ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 'test-audio-url', ConvertedTtsTransformerInterface::KEY_MESSAGE => 42], sprintf(ConvertedTtsTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedTtsTransformerInterface::KEY_MESSAGE)];
        yield 'audioUrlAbsent' => [[ConvertedTtsTransformerInterface::KEY_MESSAGE => 'test-message'], sprintf(ConvertedTtsTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedTtsTransformerInterface::KEY_AUDIO_URL)];
        yield 'audioUrlWrongType' => [[ConvertedTtsTransformerInterface::KEY_MESSAGE => 'test-message', ConvertedTtsTransformerInterface::KEY_AUDIO_URL => 42], sprintf(ConvertedTtsTransformerInterface::UNEXPECTED_STRING_SPRINTF, ConvertedTtsTransformerInterface::KEY_AUDIO_URL)];
    }
}
