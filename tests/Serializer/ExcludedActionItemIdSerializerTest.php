<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemId;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdExcludeItemSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdSerializer;
use ChristianBrown\SmartThings\Serializer\ExcludedActionItemIdSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExcludedActionItemId::class)]
#[CoversClass(ExcludedActionItemIdSerializer::class)]
final class ExcludedActionItemIdSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemSerializer = self::createStub(ExcludedActionItemIdExcludeItemSerializerInterface::class);
        $excludedActionItemIdExcludeItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-action-item-id-exclude-item']);
        $model = new ExcludedActionItemId([$excludedActionItemIdExcludeItemModel]);

        $serializer = new ExcludedActionItemIdSerializer($excludedActionItemIdExcludeItemSerializer);

        self::assertSame(
            [
                ExcludedActionItemIdSerializerInterface::KEY_EXCLUDE => [['test-serialized-excluded-action-item-id-exclude-item']],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $excludedActionItemIdExcludeItemModel = self::createStub(ExcludedActionItemIdExcludeItemInterface::class);
        $excludedActionItemIdExcludeItemSerializer = self::createStub(ExcludedActionItemIdExcludeItemSerializerInterface::class);
        $excludedActionItemIdExcludeItemSerializer->method('serialize')->willReturn(['test-serialized-excluded-action-item-id-exclude-item']);
        $model = (new ExcludedActionItemId([$excludedActionItemIdExcludeItemModel]))
            ->setId(7)
            ->setValue(['test-value-key' => 'test-value']);

        $serializer = new ExcludedActionItemIdSerializer($excludedActionItemIdExcludeItemSerializer);

        self::assertSame(
            [
                ExcludedActionItemIdSerializerInterface::KEY_ID => 7,
                ExcludedActionItemIdSerializerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
                ExcludedActionItemIdSerializerInterface::KEY_EXCLUDE => [['test-serialized-excluded-action-item-id-exclude-item']],
            ],
            $serializer->serialize($model)
        );
    }
}
