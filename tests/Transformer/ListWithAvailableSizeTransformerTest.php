<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ListWithAvailableSize;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeCommandTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeStateTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\ListWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ListWithAvailableSize::class)]
#[CoversClass(ListWithAvailableSizeTransformer::class)]
final class ListWithAvailableSizeTransformerTest extends TestCase
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
            ListWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested'],
            ListWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested'],
            ListWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
        ];

        $transformer = new ListWithAvailableSizeTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($listWithAvailableSizeCommandModel, $actual->getCommand());
        self::assertSame($listWithAvailableSizeStateModel, $actual->getState());
        self::assertSame(['test-available-sizes-1', 'test-available-sizes-2'], $actual->getAvailableSizes());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ListWithAvailableSizeTransformer(self::createStub(ListWithAvailableSizeCommandTransformerInterface::class), self::createStub(ListWithAvailableSizeStateTransformerInterface::class));

        $actual = $transformer->transform([ListWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested']] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'availableSizesAbsent' => [[], 'getAvailableSizes', null];
        yield 'availableSizesWrongType' => [[ListWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => 'not-array'], 'getAvailableSizes', null];
        yield 'availableSizesValid' => [[ListWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2']], 'getAvailableSizes', ['test-available-sizes-1', 'test-available-sizes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandTransformer = self::createStub(ListWithAvailableSizeCommandTransformerInterface::class);
        $listWithAvailableSizeCommandTransformer->method('transform')->willReturn($listWithAvailableSizeCommandModel);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateTransformer = self::createStub(ListWithAvailableSizeStateTransformerInterface::class);
        $listWithAvailableSizeStateTransformer->method('transform')->willReturn($listWithAvailableSizeStateModel);
        $transformer = new ListWithAvailableSizeTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);

        $actual = $transformer->transform([ListWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested']]);

        self::assertNull($actual->getState());
        self::assertNull($actual->getAvailableSizes());
    }

    public function testTransformState(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandTransformer = self::createStub(ListWithAvailableSizeCommandTransformerInterface::class);
        $listWithAvailableSizeCommandTransformer->method('transform')->willReturn($listWithAvailableSizeCommandModel);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateTransformer = self::createStub(ListWithAvailableSizeStateTransformerInterface::class);
        $listWithAvailableSizeStateTransformer->method('transform')->willReturn($listWithAvailableSizeStateModel);
        $transformer = new ListWithAvailableSizeTransformer($listWithAvailableSizeCommandTransformer, $listWithAvailableSizeStateTransformer);
        $base = [ListWithAvailableSizeTransformerInterface::KEY_COMMAND => ['test-nested']];

        self::assertNull($transformer->transform($base)->getState());
        self::assertNull($transformer->transform($base + [ListWithAvailableSizeTransformerInterface::KEY_STATE => 'test-not-array'])->getState());
        self::assertSame($listWithAvailableSizeStateModel, $transformer->transform($base + [ListWithAvailableSizeTransformerInterface::KEY_STATE => ['test-nested']])->getState());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new ListWithAvailableSizeTransformer(self::createStub(ListWithAvailableSizeCommandTransformerInterface::class), self::createStub(ListWithAvailableSizeStateTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'commandAbsent' => [[], sprintf(ListWithAvailableSizeTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeTransformerInterface::KEY_COMMAND)];
        yield 'commandWrongType' => [[ListWithAvailableSizeTransformerInterface::KEY_COMMAND => 'not-array'], sprintf(ListWithAvailableSizeTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ListWithAvailableSizeTransformerInterface::KEY_COMMAND)];
    }
}
