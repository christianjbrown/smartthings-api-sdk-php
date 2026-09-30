<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusCamera;
use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraImageTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraOverlayIconsItemTransformerInterface;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraTransformer;
use ChristianBrown\SmartThings\Transformer\BasicPlusCameraTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCamera::class)]
#[CoversClass(BasicPlusCameraTransformer::class)]
final class BasicPlusCameraTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $basicPlusCameraImageModel = self::createStub(BasicPlusCameraImageInterface::class);
        $basicPlusCameraImageTransformer = self::createStub(BasicPlusCameraImageTransformerInterface::class);
        $basicPlusCameraImageTransformer->method('transform')->willReturn($basicPlusCameraImageModel);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer = self::createStub(BasicPlusCameraOverlayIconsItemTransformerInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer->method('transform')->willReturn($basicPlusCameraOverlayIconsItemModel);
        $data = [
            BasicPlusCameraTransformerInterface::KEY_IMAGE => ['test-nested'],
            BasicPlusCameraTransformerInterface::KEY_OVERLAY_ICONS => [['test-nested']],
        ];

        $transformer = new BasicPlusCameraTransformer($basicPlusCameraImageTransformer, $basicPlusCameraOverlayIconsItemTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($basicPlusCameraImageModel, $actual->getImage());
        self::assertSame([$basicPlusCameraOverlayIconsItemModel], $actual->getOverlayIcons());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new BasicPlusCameraTransformer(self::createStub(BasicPlusCameraImageTransformerInterface::class), self::createStub(BasicPlusCameraOverlayIconsItemTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'imageAbsent' => [[], 'getImage', null];
        yield 'imageWrongType' => [[BasicPlusCameraTransformerInterface::KEY_IMAGE => 'not-array'], 'getImage', null];
    }

    public function testTransformOverlayIcons(): void
    {
        $basicPlusCameraImageModel = self::createStub(BasicPlusCameraImageInterface::class);
        $basicPlusCameraImageTransformer = self::createStub(BasicPlusCameraImageTransformerInterface::class);
        $basicPlusCameraImageTransformer->method('transform')->willReturn($basicPlusCameraImageModel);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer = self::createStub(BasicPlusCameraOverlayIconsItemTransformerInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer->method('transform')->willReturn($basicPlusCameraOverlayIconsItemModel);
        $transformer = new BasicPlusCameraTransformer($basicPlusCameraImageTransformer, $basicPlusCameraOverlayIconsItemTransformer);
        $base = [BasicPlusCameraTransformerInterface::KEY_IMAGE => ['test-nested']];

        self::assertNull($transformer->transform($base)->getOverlayIcons());
        self::assertNull($transformer->transform($base + [BasicPlusCameraTransformerInterface::KEY_OVERLAY_ICONS => 'test-not-array'])->getOverlayIcons());
        self::assertSame([$basicPlusCameraOverlayIconsItemModel], $transformer->transform($base + [BasicPlusCameraTransformerInterface::KEY_OVERLAY_ICONS => [['test-nested'], 'test-skipped']])->getOverlayIcons());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $basicPlusCameraImageModel = self::createStub(BasicPlusCameraImageInterface::class);
        $basicPlusCameraImageTransformer = self::createStub(BasicPlusCameraImageTransformerInterface::class);
        $basicPlusCameraImageTransformer->method('transform')->willReturn($basicPlusCameraImageModel);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer = self::createStub(BasicPlusCameraOverlayIconsItemTransformerInterface::class);
        $basicPlusCameraOverlayIconsItemTransformer->method('transform')->willReturn($basicPlusCameraOverlayIconsItemModel);
        $transformer = new BasicPlusCameraTransformer($basicPlusCameraImageTransformer, $basicPlusCameraOverlayIconsItemTransformer);

        $actual = $transformer->transform([BasicPlusCameraTransformerInterface::KEY_IMAGE => ['test-nested']]);

        self::assertNull($actual->getOverlayIcons());
    }
}
