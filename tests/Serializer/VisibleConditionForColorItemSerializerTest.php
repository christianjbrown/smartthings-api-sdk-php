<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\VisibleConditionForColorItem;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemReferToInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemReferToSerializerInterface;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemSerializer;
use ChristianBrown\SmartThings\Serializer\VisibleConditionForColorItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(VisibleConditionForColorItem::class)]
#[CoversClass(VisibleConditionForColorItemSerializer::class)]
final class VisibleConditionForColorItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $visibleConditionForColorItemReferToModel = self::createStub(VisibleConditionForColorItemReferToInterface::class);
        $visibleConditionForColorItemReferToSerializer = self::createStub(VisibleConditionForColorItemReferToSerializerInterface::class);
        $visibleConditionForColorItemReferToSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-color-item-refer-to']);
        $model = new VisibleConditionForColorItem('test-operator', 'test-operand');

        $serializer = new VisibleConditionForColorItemSerializer($visibleConditionForColorItemReferToSerializer);

        self::assertSame(
            [
                VisibleConditionForColorItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForColorItemSerializerInterface::KEY_OPERAND => 'test-operand',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $visibleConditionForColorItemReferToModel = self::createStub(VisibleConditionForColorItemReferToInterface::class);
        $visibleConditionForColorItemReferToSerializer = self::createStub(VisibleConditionForColorItemReferToSerializerInterface::class);
        $visibleConditionForColorItemReferToSerializer->method('serialize')->willReturn(['test-serialized-visible-condition-for-color-item-refer-to']);
        $model = (new VisibleConditionForColorItem('test-operator', 'test-operand'))
            ->setReferTo($visibleConditionForColorItemReferToModel);

        $serializer = new VisibleConditionForColorItemSerializer($visibleConditionForColorItemReferToSerializer);

        self::assertSame(
            [
                VisibleConditionForColorItemSerializerInterface::KEY_REFER_TO => ['test-serialized-visible-condition-for-color-item-refer-to'],
                VisibleConditionForColorItemSerializerInterface::KEY_OPERATOR => 'test-operator',
                VisibleConditionForColorItemSerializerInterface::KEY_OPERAND => 'test-operand',
            ],
            $serializer->serialize($model)
        );
    }
}
