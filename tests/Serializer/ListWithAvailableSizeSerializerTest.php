<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ListWithAvailableSize;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeSerializer;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListWithAvailableSize::class)]
#[CoversClass(ListWithAvailableSizeSerializer::class)]
final class ListWithAvailableSizeSerializerTest extends TestCase
{
    public function testSerializeNestedAbsent(): void
    {
        $listWithAvailableSizeCommandSerializer = self::createStub(ListWithAvailableSizeCommandSerializerInterface::class);
        $listWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-command']);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateSerializer = self::createStub(ListWithAvailableSizeStateSerializerInterface::class);
        $listWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-state']);
        $model = new ListWithAvailableSize(null);

        $serializer = new ListWithAvailableSizeSerializer($listWithAvailableSizeCommandSerializer, $listWithAvailableSizeStateSerializer);

        self::assertSame(
            [],
            $serializer->serialize($model)
        );
    }

    public function testSerializeRequiredFieldsOnly(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandSerializer = self::createStub(ListWithAvailableSizeCommandSerializerInterface::class);
        $listWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-command']);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateSerializer = self::createStub(ListWithAvailableSizeStateSerializerInterface::class);
        $listWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-state']);
        $model = new ListWithAvailableSize($listWithAvailableSizeCommandModel);

        $serializer = new ListWithAvailableSizeSerializer($listWithAvailableSizeCommandSerializer, $listWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeSerializerInterface::KEY_COMMAND => ['test-serialized-list-with-available-size-command'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandSerializer = self::createStub(ListWithAvailableSizeCommandSerializerInterface::class);
        $listWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-command']);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateSerializer = self::createStub(ListWithAvailableSizeStateSerializerInterface::class);
        $listWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-state']);
        $model = (new ListWithAvailableSize($listWithAvailableSizeCommandModel))
            ->setState($listWithAvailableSizeStateModel)
            ->setAvailableSizes(['test-available-sizes-1', 'test-available-sizes-2']);

        $serializer = new ListWithAvailableSizeSerializer($listWithAvailableSizeCommandSerializer, $listWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                ListWithAvailableSizeSerializerInterface::KEY_COMMAND => ['test-serialized-list-with-available-size-command'],
                ListWithAvailableSizeSerializerInterface::KEY_STATE => ['test-serialized-list-with-available-size-state'],
                ListWithAvailableSizeSerializerInterface::KEY_AVAILABLE_SIZES => ['test-available-sizes-1', 'test-available-sizes-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
