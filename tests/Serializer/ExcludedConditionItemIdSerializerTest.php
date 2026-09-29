<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemId;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdExcludeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedConditionItemIdSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedConditionItemId::class)]
#[CoversClass(ExcludedConditionItemIdSerializer::class)]
final class ExcludedConditionItemIdSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item']);
        $model = new ExcludedConditionItemId([$excludedConditionItemIdExcludeItemModel]);

        $serializer = new ExcludedConditionItemIdSerializer($excludedConditionItemIdExcludeItemSerializer);

        self::assertSame(
            [
                ExcludedConditionItemIdSerializerInterface::KEY_EXCLUDE => [['test-serialized-excluded-condition-item-id-exclude-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $excludedConditionItemIdExcludeItemModel = self::createStub(ExcludedConditionItemIdExcludeItemInterface::class);
        $excludedConditionItemIdExcludeItemSerializer = self::createStub(ExcludedConditionItemIdExcludeItemSerializerInterface::class);
        $excludedConditionItemIdExcludeItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-condition-item-id-exclude-item']);
        $model = (new ExcludedConditionItemId([$excludedConditionItemIdExcludeItemModel]))
            ->setId(7)
            ->setValue(['test-value-key' => 'test-value']);

        $serializer = new ExcludedConditionItemIdSerializer($excludedConditionItemIdExcludeItemSerializer);

        self::assertSame(
            [
                ExcludedConditionItemIdSerializerInterface::KEY_ID => 7,
                ExcludedConditionItemIdSerializerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
                ExcludedConditionItemIdSerializerInterface::KEY_EXCLUDE => [['test-serialized-excluded-condition-item-id-exclude-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
