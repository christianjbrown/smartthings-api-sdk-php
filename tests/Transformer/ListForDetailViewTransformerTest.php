<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ListForDetailView;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformer;
use ChristianBrown\SmartThings\Transformer\ListForDetailViewTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListForDetailView::class)]
#[CoversClass(ListForDetailViewTransformer::class)]
final class ListForDetailViewTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandTransformer = self::createStub(ListWithAvailableSizeCommandTransformerInterface::class);
        $listWithAvailableSizeCommandTransformer->method('transform')->willReturn($listWithAvailableSizeCommandModel);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateTransformer = self::createStub(ListWithAvailableSizeStateTransformerInterface::class);
        $listWithAvailableSizeStateTransformer->method('transform')->willReturn($listWithAvailableSizeStateModel);
        $data = [
            ListForDetailViewTransformerInterface::KEY_COMMAND => ['test-nested'],
            ListForDetailViewTransformerInterface::KEY_STATE => ['test-nested'],
        ];

        $transformer = new ListForDetailViewTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($listWithAvailableSizeCommandModel, $actual->getCommand());
        self::assertSame($listWithAvailableSizeStateModel, $actual->getState());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandTransformer = self::createStub(ListWithAvailableSizeCommandTransformerInterface::class);
        $listWithAvailableSizeCommandTransformer->method('transform')->willReturn($listWithAvailableSizeCommandModel);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateTransformer = self::createStub(ListWithAvailableSizeStateTransformerInterface::class);
        $listWithAvailableSizeStateTransformer->method('transform')->willReturn($listWithAvailableSizeStateModel);
        $transformer = new ListForDetailViewTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);

        $actual = $transformer->transform([ListForDetailViewTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getState());
    }

    public function testTransformState(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandTransformer = self::createStub(ListWithAvailableSizeCommandTransformerInterface::class);
        $listWithAvailableSizeCommandTransformer->method('transform')->willReturn($listWithAvailableSizeCommandModel);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateTransformer = self::createStub(ListWithAvailableSizeStateTransformerInterface::class);
        $listWithAvailableSizeStateTransformer->method('transform')->willReturn($listWithAvailableSizeStateModel);
        $transformer = new ListForDetailViewTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);
        $base = [ListForDetailViewTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [ListForDetailViewTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($listWithAvailableSizeStateModel, $transformer->transform($base + [ListForDetailViewTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListForDetailViewTransformer(self::createStub(ListWithAvailableSizeCommandTransformerInterface::class), self::createStub(ListWithAvailableSizeStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(ListForDetailViewTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForDetailViewTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[ListForDetailViewTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(ListForDetailViewTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListForDetailViewTransformerInterface::KEY_COMMAND)];
    }
}
