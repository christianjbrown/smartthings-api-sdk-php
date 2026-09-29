<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\PlayedText;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(PlayedText::class)]
#[CoversClass(PlayedTextTransformer::class)]
final class PlayedTextTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            PlayedTextTransformerInterface::KEY_MESSAGE => 'test-message',
        ];

        $transformer = new PlayedTextTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-message', $actual->getMessage());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new PlayedTextTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'messageAbsent' => [[], sprintf(PlayedTextTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayedTextTransformerInterface::KEY_MESSAGE)];
        yield 'messageWrongType' => [[PlayedTextTransformerInterface::KEY_MESSAGE => 42], sprintf(PlayedTextTransformerInterface::UNEXPECTED_STRING_SPRINTF, PlayedTextTransformerInterface::KEY_MESSAGE)];
    }
}
