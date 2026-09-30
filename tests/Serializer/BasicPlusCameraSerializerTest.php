<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCamera;
use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraImageSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraOverlayIconsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCamera::class)]
#[CoversClass(BasicPlusCameraSerializer::class)]
final class BasicPlusCameraSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $basicPlusCameraImageSerializer = self::createStub(BasicPlusCameraImageSerializerInterface::class);
        $basicPlusCameraImageSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-image']);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer = self::createStub(BasicPlusCameraOverlayIconsItemSerializerInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-overlay-icons-item']);
        $model = new BasicPlusCamera(null);

        $serializer = new BasicPlusCameraSerializer($basicPlusCameraImageSerializer, $basicPlusCameraOverlayIconsItemSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusCameraImageModel = self::createStub(BasicPlusCameraImageInterface::class);
        $basicPlusCameraImageSerializer = self::createStub(BasicPlusCameraImageSerializerInterface::class);
        $basicPlusCameraImageSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-image']);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer = self::createStub(BasicPlusCameraOverlayIconsItemSerializerInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-overlay-icons-item']);
        $model = new BasicPlusCamera($basicPlusCameraImageModel);

        $serializer = new BasicPlusCameraSerializer($basicPlusCameraImageSerializer, $basicPlusCameraOverlayIconsItemSerializer);

        self::assertSame(
            [
                BasicPlusCameraSerializerInterface::KEY_IMAGE => ['test-serialized-basic-plus-camera-image'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusCameraImageModel = self::createStub(BasicPlusCameraImageInterface::class);
        $basicPlusCameraImageSerializer = self::createStub(BasicPlusCameraImageSerializerInterface::class);
        $basicPlusCameraImageSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-image']);
        $basicPlusCameraOverlayIconsItemModel = self::createStub(BasicPlusCameraOverlayIconsItemInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer = self::createStub(BasicPlusCameraOverlayIconsItemSerializerInterface::class);
        $basicPlusCameraOverlayIconsItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-camera-overlay-icons-item']);
        $model = (new BasicPlusCamera($basicPlusCameraImageModel))
            ->setOverlayIcons([$basicPlusCameraOverlayIconsItemModel]);

        $serializer = new BasicPlusCameraSerializer($basicPlusCameraImageSerializer, $basicPlusCameraOverlayIconsItemSerializer);

        self::assertSame(
            [
                BasicPlusCameraSerializerInterface::KEY_IMAGE => ['test-serialized-basic-plus-camera-image'],
                BasicPlusCameraSerializerInterface::KEY_OVERLAY_ICONS => [['test-serialized-basic-plus-camera-overlay-icons-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
