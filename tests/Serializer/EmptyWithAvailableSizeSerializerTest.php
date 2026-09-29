<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSize;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\EmptyWithAvailableSizeSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EmptyWithAvailableSize::class)]
#[CoversClass(EmptyWithAvailableSizeSerializer::class)]
final class EmptyWithAvailableSizeSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new EmptyWithAvailableSize();

        $serializer = new EmptyWithAvailableSizeSerializer();

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new EmptyWithAvailableSize())
            ->setAvailableSizes(['test-available-sizes-1', 'test-available-sizes-2']);

        $serializer = new EmptyWithAvailableSizeSerializer();

        self::assertSame(
            [
                EmptyWithAvailableSizeSerializerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
