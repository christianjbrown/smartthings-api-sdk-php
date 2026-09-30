<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\VisibleConditionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCameraOverlayIconsItem::class)]
#[CoversClass(BasicPlusCameraOverlayIconsItemTransformer::class)]
final class BasicPlusCameraOverlayIconsItemTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $data = [
            BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url',
            BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested'],
        ];

        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-icon-url', $actual->getIconUrl());
        self::assertSame($visibleConditionModel, $actual->getVisibleCondition());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer(self::createStub(VisibleConditionTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'iconUrlAbsent' => [[], 'getIconUrl', null];
        yield 'iconUrlWrongType' => [[BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 42], 'getIconUrl', null];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);

        $actual = $transformer->transform([BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url']);

        self::assertNull($actual->getVisibleCondition());
    }

    public function testTransformVisibleCondition(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionTransformer = self::createStub(VisibleConditionTransformerInterface::class);
        $visibleConditionTransformer->method('transform')->willReturn($visibleConditionModel);
        $transformer = new BasicPlusCameraOverlayIconsItemTransformer($visibleConditionTransformer);
        $base = [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_ICON_URL => 'test-icon-url'];

        self::assertNull($transformer->transform($base)->getVisibleCondition());
        self::assertNull($transformer->transform($base + [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => 'test-not-array'])->getVisibleCondition());
        self::assertSame($visibleConditionModel, $transformer->transform($base + [BasicPlusCameraOverlayIconsItemTransformerInterface::KEY_VISIBLE_CONDITION => ['test-nested']])->getVisibleCondition());
    }
}
