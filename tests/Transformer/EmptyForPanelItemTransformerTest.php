<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EmptyForPanelItem;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EmptyForPanelItem::class)]
#[CoversClass(EmptyForPanelItemTransformer::class)]
final class EmptyForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EmptyForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new EmptyForPanelItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-size', $actual->getSize());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new EmptyForPanelItemTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'sizeAbsent' => [[], 'getSize', null];
        yield 'sizeWrongType' => [[EmptyForPanelItemTransformerInterface::KEY_SIZE => 42], 'getSize', null];
    }
}
