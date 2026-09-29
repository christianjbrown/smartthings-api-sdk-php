<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraOverlayIconsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusCameraOverlayIconsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusCameraOverlayIconsItem::class)]
#[CoversClass(BasicPlusCameraOverlayIconsItemSerializer::class)]
final class BasicPlusCameraOverlayIconsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new BasicPlusCameraOverlayIconsItem('test-icon-url');

        $serializer = new BasicPlusCameraOverlayIconsItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusCameraOverlayIconsItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new BasicPlusCameraOverlayIconsItem('test-icon-url'))
            ->setVisibleCondition($visibleConditionModel);

        $serializer = new BasicPlusCameraOverlayIconsItemSerializer($visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusCameraOverlayIconsItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                BasicPlusCameraOverlayIconsItemSerializerInterface::KEY_VISIBLE_CONDITION => ['test-serialized-visible-condition'],
            ],
            $serializer->serialize($model)
        );
    }
}
