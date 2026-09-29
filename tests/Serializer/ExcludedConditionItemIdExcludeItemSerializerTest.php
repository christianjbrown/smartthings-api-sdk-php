<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedConditionItemIdExcludeItem::class)]
#[CoversClass(ExcludedConditionItemIdExcludeItemSerializer::class)]
final class ExcludedConditionItemIdExcludeItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']);
        $model = new ExcludedConditionItemIdExcludeItem('test-capability');

        $serializer = new ExcludedConditionItemIdExcludeItemSerializer($excludedConditionItemIdExcludeItemAttributesItemSerializer);

        self::assertSame(
            [
                ExcludedConditionItemIdExcludeItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']);
        $model = (new ExcludedConditionItemIdExcludeItem('test-capability'))
            ->setComponent('test-component')
            ->setVersion(7)
            ->setAttributes([$excludedConditionItemIdExcludeItemAttributesItemModel]);

        $serializer = new ExcludedConditionItemIdExcludeItemSerializer($excludedConditionItemIdExcludeItemAttributesItemSerializer);

        self::assertSame(
            [
                ExcludedConditionItemIdExcludeItemSerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedConditionItemIdExcludeItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                ExcludedConditionItemIdExcludeItemSerializerInterface::KEY_VERSION => 7,
                ExcludedConditionItemIdExcludeItemSerializerInterface::KEY_ATTRIBUTES => [['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
