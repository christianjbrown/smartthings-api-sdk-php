<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ListForPanelItem;
use ChristianBrown\SmartThings\Model\ListForPanelItemCommandInterface;
use ChristianBrown\SmartThings\Model\ListForPanelItemStateInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\ListForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForPanelItem::class)]
#[CoversClass(ListForPanelItemTransformer::class)]
final class ListForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $listForPanelItemCommandModel = self::createStub(ListForPanelItemCommandInterface::class);
        $listForPanelItemCommandTransformer = self::createStub(ListForPanelItemCommandTransformerInterface::class);
        $listForPanelItemCommandTransformer->method('transform')->willReturn($listForPanelItemCommandModel);
        $listForPanelItemStateModel = self::createStub(ListForPanelItemStateInterface::class);
        $listForPanelItemStateTransformer = self::createStub(ListForPanelItemStateTransformerInterface::class);
        $listForPanelItemStateTransformer->method('transform')->willReturn($listForPanelItemStateModel);
        $data = [
            ListForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'],
            ListForPanelItemTransformerInterface::KEY_STATE => ['test-nested'],
            ListForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new ListForPanelItemTransformer($listForPanelItemCommandTransformer, $listForPanelItemStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($listForPanelItemCommandModel, $actual->getCommand());
        self::assertSame($listForPanelItemStateModel, $actual->getState());
        self::assertSame('test-size', $actual->getSize());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $listForPanelItemCommandModel = self::createStub(ListForPanelItemCommandInterface::class);
        $listForPanelItemCommandTransformer = self::createStub(ListForPanelItemCommandTransformerInterface::class);
        $listForPanelItemCommandTransformer->method('transform')->willReturn($listForPanelItemCommandModel);
        $listForPanelItemStateModel = self::createStub(ListForPanelItemStateInterface::class);
        $listForPanelItemStateTransformer = self::createStub(ListForPanelItemStateTransformerInterface::class);
        $listForPanelItemStateTransformer->method('transform')->willReturn($listForPanelItemStateModel);
        $transformer = new ListForPanelItemTransformer($listForPanelItemCommandTransformer, $listForPanelItemStateTransformer);

        $actual = $transformer->transform([ListForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], ListForPanelItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getState());
    }

    public function testTransformState(): void
    {
        $listForPanelItemCommandModel = self::createStub(ListForPanelItemCommandInterface::class);
        $listForPanelItemCommandTransformer = self::createStub(ListForPanelItemCommandTransformerInterface::class);
        $listForPanelItemCommandTransformer->method('transform')->willReturn($listForPanelItemCommandModel);
        $listForPanelItemStateModel = self::createStub(ListForPanelItemStateInterface::class);
        $listForPanelItemStateTransformer = self::createStub(ListForPanelItemStateTransformerInterface::class);
        $listForPanelItemStateTransformer->method('transform')->willReturn($listForPanelItemStateModel);
        $transformer = new ListForPanelItemTransformer($listForPanelItemCommandTransformer, $listForPanelItemStateTransformer);
        $base = [ListForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], ListForPanelItemTransformerInterface::KEY_SIZE => 'test-size'];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [ListForPanelItemTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($listForPanelItemStateModel, $transformer->transform($base + [ListForPanelItemTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListForPanelItemTransformer(self::createStub(ListForPanelItemCommandTransformerInterface::class), self::createStub(ListForPanelItemStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[ListForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], sprintf(ListForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[ListForPanelItemTransformerInterface::KEY_SIZE => 'test-size', ListForPanelItemTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(ListForPanelItemTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForPanelItemTransformerInterface::KEY_COMMAND)];
        yield 'sizeAbsent' => [[ListForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested']], sprintf(ListForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForPanelItemTransformerInterface::KEY_SIZE)];
        yield 'sizeWrongType' => [[ListForPanelItemTransformerInterface::KEY_COMMAND => ['test-nested'], ListForPanelItemTransformerInterface::KEY_SIZE => 42], sprintf(ListForPanelItemTransformerInterface::UNEXPECTED_STRING_SPRINTF, ListForPanelItemTransformerInterface::KEY_SIZE)];
    }
}
