<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\ListForDetailView;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;
use ChristianBrown\SmartThings\Serializer\ListForDetailViewSerializer;
use ChristianBrown\SmartThings\Serializer\ListForDetailViewSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeCommandSerializerInterface;
use ChristianBrown\SmartThings\Serializer\ListWithAvailableSizeStateSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ListForDetailView::class)]
#[CoversClass(ListForDetailViewSerializer::class)]
final class ListForDetailViewSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $listWithAvailableSizeCommandModel = self::createStub(ListWithAvailableSizeCommandInterface::class);
        $listWithAvailableSizeCommandSerializer = self::createStub(ListWithAvailableSizeCommandSerializerInterface::class);
        $listWithAvailableSizeCommandSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-command']);
        $listWithAvailableSizeStateModel = self::createStub(ListWithAvailableSizeStateInterface::class);
        $listWithAvailableSizeStateSerializer = self::createStub(ListWithAvailableSizeStateSerializerInterface::class);
        $listWithAvailableSizeStateSerializer->method('serialize')->willReturn(['test-serialized-list-with-available-size-state']);
        $model = new ListForDetailView($listWithAvailableSizeCommandModel);

        $serializer = new ListForDetailViewSerializer($listWithAvailableSizeCommandSerializer, $listWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                ListForDetailViewSerializerInterface::KEY_COMMAND => ['test-serialized-list-with-available-size-command'],
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
        $model = (new ListForDetailView($listWithAvailableSizeCommandModel))
            ->setState($listWithAvailableSizeStateModel);

        $serializer = new ListForDetailViewSerializer($listWithAvailableSizeCommandSerializer, $listWithAvailableSizeStateSerializer);

        self::assertSame(
            [
                ListForDetailViewSerializerInterface::KEY_COMMAND => ['test-serialized-list-with-available-size-command'],
                ListForDetailViewSerializerInterface::KEY_STATE => ['test-serialized-list-with-available-size-state'],
            ],
            $serializer->serialize($model)
        );
    }
}
