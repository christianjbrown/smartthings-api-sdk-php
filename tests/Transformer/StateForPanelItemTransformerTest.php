<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StateForPanelItem;
use ChristianBrown\SmartThings\Transformer\AlternativeItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\StateForPanelItemTransformer;
use ChristianBrown\SmartThings\Transformer\StateForPanelItemTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StateForPanelItem::class)]
#[CoversClass(StateForPanelItemTransformer::class)]
final class StateForPanelItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $data = [
            StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label',
            StateForPanelItemTransformerInterface::KEY_UNIT => 'test-unit',
            StateForPanelItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested']],
            StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size',
        ];

        $transformer = new StateForPanelItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-label', $actual->getLabel());
        self::assertSame('test-unit', $actual->getUnit());
        self::assertSame([$alternativeItemModel], $actual->getAlternatives());
        self::assertSame('test-size', $actual->getSize());
    }

    public function testTransformAlternatives(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateForPanelItemTransformer($alternativeItemTransformer);
        $base = [StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label', StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size'];

        self::assertNull($transformer->transform($base)->getAlternatives());
        self::assertNull($transformer->transform($base + [StateForPanelItemTransformerInterface::KEY_ALTERNATIVES => 'test-not-array'])->getAlternatives());
        self::assertSame([$alternativeItemModel], $transformer->transform($base + [StateForPanelItemTransformerInterface::KEY_ALTERNATIVES => [['test-nested'], 'test-skipped']])->getAlternatives());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new StateForPanelItemTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'labelAbsent' => [[StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size'], 'getLabel', null];
        yield 'labelWrongType' => [[StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size', StateForPanelItemTransformerInterface::KEY_LABEL => 42], 'getLabel', null];
        yield 'sizeAbsent' => [[StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label'], 'getSize', null];
        yield 'sizeWrongType' => [[StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label', StateForPanelItemTransformerInterface::KEY_SIZE => 42], 'getSize', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new StateForPanelItemTransformer(self::createStub(AlternativeItemTransformerInterface::class));

        $actual = $transformer->transform([StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label', StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'unitAbsent' => [[], 'getUnit', null];
        yield 'unitWrongType' => [[StateForPanelItemTransformerInterface::KEY_UNIT => 42], 'getUnit', null];
        yield 'unitValid' => [[StateForPanelItemTransformerInterface::KEY_UNIT => 'test-unit'], 'getUnit', 'test-unit'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemTransformer = self::createStub(AlternativeItemTransformerInterface::class);
        $alternativeItemTransformer->method('transform')->willReturn($alternativeItemModel);
        $transformer = new StateForPanelItemTransformer($alternativeItemTransformer);

        $actual = $transformer->transform([StateForPanelItemTransformerInterface::KEY_LABEL => 'test-label', StateForPanelItemTransformerInterface::KEY_SIZE => 'test-size']);

        self::assertNull($actual->getUnit());
        self::assertNull($actual->getAlternatives());
    }
}
