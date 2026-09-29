<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSize;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateWithAvailableSizeTransformer;
use ChristianBrown\SmartThings\Transformer\StateWithAvailableSizeTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(StateWithAvailableSize::class)]
#[CoversClass(StateWithAvailableSizeTransformer::class)]
final class StateWithAvailableSizeTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StateWithAvailableSizeTransformerInterface::KEY_LABEL => 'test-label',
            StateWithAvailableSizeTransformerInterface::KEY_UNIT => 'test-unit',
            StateWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            StateWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
        ];

        $transformer = new StateWithAvailableSizeTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame(['test-available-sizes-1', 'test-available-sizes-2'], $actual->getAvailableSizes());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateWithAvailableSizeTransformer($alternativeItemTransformer);
        $base = [StateWithAvailableSizeTransformerInterface::KEY_LABEL => 'test-label'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StateWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StateWithAvailableSizeTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StateWithAvailableSizeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([StateWithAvailableSizeTransformerInterface::KEY_LABEL => 'test-label'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[StateWithAvailableSizeTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[StateWithAvailableSizeTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
        yield 'availableSizesAbsent' => [[], 'getAvailableSizes', null];
        yield 'availableSizesWrongType' => [[StateWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => 'not-array'], 'getAvailableSizes', null];
        yield 'availableSizesValid' => [[StateWithAvailableSizeTransformerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2']], 'getAvailableSizes', ['test-available-sizes-1', 'test-available-sizes-2']];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateWithAvailableSizeTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StateWithAvailableSizeTransformerInterface::KEY_LABEL => 'test-label']);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getAlternatives());
        self::assertNull($actual->getAvailableSizes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new StateWithAvailableSizeTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'labelAbsent' => [[], sprintf(StateWithAvailableSizeTransformerInterface::UNEXPECTED_STRING_SPRINTF, StateWithAvailableSizeTransformerInterface::KEY_LABEL)];
        yield 'labelWrongType' => [[StateWithAvailableSizeTransformerInterface::KEY_LABEL => 42], sprintf(StateWithAvailableSizeTransformerInterface::UNEXPECTED_STRING_SPRINTF, StateWithAvailableSizeTransformerInterface::KEY_LABEL)];
    }
}
