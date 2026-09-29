<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItem;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedConditionItemIdExcludeItemAttributesItem::class)]
#[CoversClass(ExcludedConditionItemIdExcludeItemAttributesItemSerializer::class)]
final class ExcludedConditionItemIdExcludeItemAttributesItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new ExcludedConditionItemIdExcludeItemAttributesItem('test-name');

        $serializer = new ExcludedConditionItemIdExcludeItemAttributesItemSerializer();

        self::assertSame(
            [
                ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::KEY_NAME => 'test-name',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new ExcludedConditionItemIdExcludeItemAttributesItem('test-name'))
            ->setExcludedValues(['test-excluded-values-1', 'test-excluded-values-2']);

        $serializer = new ExcludedConditionItemIdExcludeItemAttributesItemSerializer();

        self::assertSame(
            [
                ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::KEY_NAME => 'test-name',
                ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface::KEY_EXCLUDED_VALUES => ['test-excluded-values-1', 'test-excluded-values-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
