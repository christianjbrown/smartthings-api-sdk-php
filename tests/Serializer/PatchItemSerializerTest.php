<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\PatchItem;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializer;
use ChristianBrown\SmartThings\Serializer\PatchItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PatchItem::class)]
#[CoversClass(PatchItemSerializer::class)]
final class PatchItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new PatchItem('test-op', 'test-path');

        $serializer = new PatchItemSerializer();

        self::assertSame(
            [
                PatchItemSerializerInterface::KEY_OP => 'test-op',
                PatchItemSerializerInterface::KEY_PATH => 'test-path',
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new PatchItem('test-op', 'test-path'))
            ->setValue(['test-value-key' => 'test-value']);

        $serializer = new PatchItemSerializer();

        self::assertSame(
            [
                PatchItemSerializerInterface::KEY_OP => 'test-op',
                PatchItemSerializerInterface::KEY_PATH => 'test-path',
                PatchItemSerializerInterface::KEY_VALUE => ['test-value-key' => 'test-value'],
            ],
            $serializer->serialize($model)
        );
    }
}
