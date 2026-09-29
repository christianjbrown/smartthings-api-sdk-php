<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItem;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemProgressBarsItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusItemProgressBarsItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsBarItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusProgressBarsStateItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusItemProgressBarsItem::class)]
#[CoversClass(BasicPlusItemProgressBarsItemSerializer::class)]
final class BasicPlusItemProgressBarsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemSerializer = self::createStub(BasicPlusProgressBarsStateItemSerializerInterface::class);
        $basicPlusProgressBarsStateItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-progress-bars-state-item']);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemSerializer = self::createStub(BasicPlusProgressBarsBarItemSerializerInterface::class);
        $basicPlusProgressBarsBarItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-progress-bars-bar-item']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new BasicPlusItemProgressBarsItem();

        $serializer = new BasicPlusItemProgressBarsItemSerializer($basicPlusProgressBarsStateItemSerializer, $basicPlusProgressBarsBarItemSerializer, $visibleConditionSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $basicPlusProgressBarsStateItemModel = self::createStub(BasicPlusProgressBarsStateItemInterface::class);
        $basicPlusProgressBarsStateItemSerializer = self::createStub(BasicPlusProgressBarsStateItemSerializerInterface::class);
        $basicPlusProgressBarsStateItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-progress-bars-state-item']);
        $basicPlusProgressBarsBarItemModel = self::createStub(BasicPlusProgressBarsBarItemInterface::class);
        $basicPlusProgressBarsBarItemSerializer = self::createStub(BasicPlusProgressBarsBarItemSerializerInterface::class);
        $basicPlusProgressBarsBarItemSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-progress-bars-bar-item']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new BasicPlusItemProgressBarsItem())
            ->setHeaders([$basicPlusProgressBarsStateItemModel])
            ->setBar($basicPlusProgressBarsBarItemModel)
            ->setFooters([$basicPlusProgressBarsStateItemModel])
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel]);

        $serializer = new BasicPlusItemProgressBarsItemSerializer($basicPlusProgressBarsStateItemSerializer, $basicPlusProgressBarsBarItemSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusItemProgressBarsItemSerializerInterface::KEY_HEADERS => [['test-serialized-basic-plus-progress-bars-state-item']],
                BasicPlusItemProgressBarsItemSerializerInterface::KEY_BAR => ['test-serialized-basic-plus-progress-bars-bar-item'],
                BasicPlusItemProgressBarsItemSerializerInterface::KEY_FOOTERS => [['test-serialized-basic-plus-progress-bars-state-item']],
                BasicPlusItemProgressBarsItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                BasicPlusItemProgressBarsItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
            ],
            $serializer->serialize($model)
        );
    }
}
