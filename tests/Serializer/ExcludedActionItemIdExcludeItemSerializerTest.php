<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItem;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdExcludeItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdExcludeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedActionItemIdExcludeItem::class)]
#[CoversClass(ExcludedActionItemIdExcludeItemSerializer::class)]
final class ExcludedActionItemIdExcludeItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']);
        $model = new ExcludedActionItemIdExcludeItem('test-capability');

        $serializer = new ExcludedActionItemIdExcludeItemSerializer($excludedConditionItemIdExcludeItemAttributesItemSerializer);

        self::assertSame(
            [
                ExcludedActionItemIdExcludeItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $excludedConditionItemIdExcludeItemAttributesItemModel = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemAttributesItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']);
        $model = (new ExcludedActionItemIdExcludeItem('test-capability'))
            ->setComponent('test-component')
            ->setVersion(7)
            ->setCommands([$excludedConditionItemIdExcludeItemAttributesItemModel]);

        $serializer = new ExcludedActionItemIdExcludeItemSerializer($excludedConditionItemIdExcludeItemAttributesItemSerializer);

        self::assertSame(
            [
                ExcludedActionItemIdExcludeItemSerializerInterface::KEY_COMPONENT => 'test-component',
                ExcludedActionItemIdExcludeItemSerializerInterface::KEY_CAPABILITY => 'test-capability',
                ExcludedActionItemIdExcludeItemSerializerInterface::KEY_VERSION => 7,
                ExcludedActionItemIdExcludeItemSerializerInterface::KEY_COMMANDS => [['test-serialized-excluded-condition-item-id-exclude-item-attributes-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
