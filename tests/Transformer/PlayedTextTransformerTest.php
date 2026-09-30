<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\PlayedText;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformer;
use ChristianBrown\SmartThings\Transformer\PlayedTextTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

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
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new PlayedTextTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'messageAbsent' => [[], 'getMessage', null];
        yield 'messageWrongType' => [[PlayedTextTransformerInterface::KEY_MESSAGE => 42], 'getMessage', null];
    }
}
