<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EmptyForPanelItem;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\EmptyForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new EmptyForPanelItemTransformer();

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'sizeAbsent' => [[], sprintf(EmptyForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EmptyForPanelItemTransformerInterface::KEY_SIZE)];
        yield 'sizeWrongType' => [[EmptyForPanelItemTransformerInterface::KEY_SIZE => 42], sprintf(EmptyForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, EmptyForPanelItemTransformerInterface::KEY_SIZE)];
    }
}
