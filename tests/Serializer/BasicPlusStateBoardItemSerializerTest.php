<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItem;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;
use ChristianBrown\SmartThings\Serializer\AlternativeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardColorsSerializerInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardItemSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusStateBoardItem::class)]
#[CoversClass(BasicPlusStateBoardItemSerializer::class)]
final class BasicPlusStateBoardItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsSerializer = self::createStub(BasicPlusStateBoardColorsSerializerInterface::class);
        $basicPlusStateBoardColorsSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-state-board-colors']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = new BasicPlusStateBoardItem('test-capability', 'test-component', 'test-value', 'test-label');

        $serializer = new BasicPlusStateBoardItemSerializer($alternativeItemSerializer, $basicPlusStateBoardColorsSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusStateBoardItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusStateBoardItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusStateBoardItemSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusStateBoardItemSerializerInterface::KEY_LABEL => 'test-label',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $alternativeItemModel = self::createStub(AlternativeItemInterface::class);
        $alternativeItemSerializer = self::createStub(AlternativeItemSerializerInterface::class);
        $alternativeItemSerializer->method('serialize')->willReturn(['test-serialized-alternative-item']);
        $basicPlusStateBoardColorsModel = self::createStub(BasicPlusStateBoardColorsInterface::class);
        $basicPlusStateBoardColorsSerializer = self::createStub(BasicPlusStateBoardColorsSerializerInterface::class);
        $basicPlusStateBoardColorsSerializer->method('serialize')->willReturn(['test-serialized-basic-plus-state-board-colors']);
        $visibleConditionModel = self::createStub(VisibleConditionInterface::class);
        $visibleConditionSerializer = self::createStub(VisibleConditionSerializerInterface::class);
        $visibleConditionSerializer->method('serialize')->willReturn(['test-serialized-visible-condition']);
        $model = (new BasicPlusStateBoardItem('test-capability', 'test-component', 'test-value', 'test-label'))
            ->setVersion(7)
            ->setValueType('test-value-type')
            ->setUnit('test-unit')
            ->setAlternatives([$alternativeItemModel])
            ->setIconUrl('test-icon-url')
            ->setColors([$basicPlusStateBoardColorsModel])
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionModel]);

        $serializer = new BasicPlusStateBoardItemSerializer($alternativeItemSerializer, $basicPlusStateBoardColorsSerializer, $visibleConditionSerializer);

        self::assertSame(
            [
                BasicPlusStateBoardItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                BasicPlusStateBoardItemSerializerInterface::KEY_VERSION => 7,
                BasicPlusStateBoardItemSerializerInterface::KEY_COMPONENT => 'test-component',
                BasicPlusStateBoardItemSerializerInterface::KEY_VALUE => 'test-value',
                BasicPlusStateBoardItemSerializerInterface::KEY_VALUE_TYPE => 'test-value-type',
                BasicPlusStateBoardItemSerializerInterface::KEY_LABEL => 'test-label',
                BasicPlusStateBoardItemSerializerInterface::KEY_UNIT => 'test-unit',
                BasicPlusStateBoardItemSerializerInterface::KEY_ALTERNATIVES => [['test-serialized-alternative-item']],
                BasicPlusStateBoardItemSerializerInterface::KEY_ICON_URL => 'test-icon-url',
                BasicPlusStateBoardItemSerializerInterface::KEY_COLORS => [['test-serialized-basic-plus-state-board-colors']],
                BasicPlusStateBoardItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                BasicPlusStateBoardItemSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition']],
            ],
            $serializer->serialize($model)
        );
    }
}
