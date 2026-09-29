<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColors;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardColorsSerializer;
use ChristianBrown\SmartThings\Serializer\BasicPlusStateBoardColorsSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BasicPlusStateBoardColors::class)]
#[CoversClass(BasicPlusStateBoardColorsSerializer::class)]
final class BasicPlusStateBoardColorsSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionForColorItemModel = self::createStub(VisibleConditionForColorItemInterface::class);
        $visibleConditionForColorItemSerializer = self::createStub(VisibleConditionForColorItemSerializerInterface::class);
        $visibleConditionForColorItemSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-color-item']);
        $model = new BasicPlusStateBoardColors('test-color');

        $serializer = new BasicPlusStateBoardColorsSerializer($visibleConditionForColorItemSerializer);

        self::assertSame(
            [
                BasicPlusStateBoardColorsSerializerInterface::KEY_COLOR => 'test-color',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionForColorItemModel = self::createStub(VisibleConditionForColorItemInterface::class);
        $visibleConditionForColorItemSerializer = self::createStub(VisibleConditionForColorItemSerializerInterface::class);
        $visibleConditionForColorItemSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-color-item']);
        $model = (new BasicPlusStateBoardColors('test-color'))
            ->setOperator('test-operator')
            ->setVisibleConditions([$visibleConditionForColorItemModel]);

        $serializer = new BasicPlusStateBoardColorsSerializer($visibleConditionForColorItemSerializer);

        self::assertSame(
            [
                BasicPlusStateBoardColorsSerializerInterface::KEY_COLOR => 'test-color',
                BasicPlusStateBoardColorsSerializerInterface::KEY_OPERATOR => 'test-operator',
                BasicPlusStateBoardColorsSerializerInterface::KEY_VISIBLE_CONDITIONS => [['test-serialized-visible-condition-for-color-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
