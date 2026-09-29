<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceComponent;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceComponentSerializer;
use ChristianBrown\SmartThings\Serializer\UpdateDeviceComponentSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UpdateDeviceComponent::class)]
#[CoversClass(UpdateDeviceComponentSerializer::class)]
final class UpdateDeviceComponentSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new UpdateDeviceComponent('test-id', ['test-categories-1', 'test-categories-2']);

        $serializer = new UpdateDeviceComponentSerializer();

        self::assertSame(
            [
                UpdateDeviceComponentSerializerInterface::KEY_ID => 'test-id',
                UpdateDeviceComponentSerializerInterface::KEY_CATEGORIES => ['test-categories-1', 'test-categories-2'],
            ],
            $serializer->serialize($model)
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $model = (new UpdateDeviceComponent('test-id', ['test-categories-1', 'test-categories-2']))
            ->setLabel('test-label')
            ->setIcon('test-icon');

        $serializer = new UpdateDeviceComponentSerializer();

        self::assertSame(
            [
                UpdateDeviceComponentSerializerInterface::KEY_ID => 'test-id',
                UpdateDeviceComponentSerializerInterface::KEY_LABEL => 'test-label',
                UpdateDeviceComponentSerializerInterface::KEY_ICON => 'test-icon',
                UpdateDeviceComponentSerializerInterface::KEY_CATEGORIES => ['test-categories-1', 'test-categories-2'],
            ],
            $serializer->serialize($model)
        );
    }
}
