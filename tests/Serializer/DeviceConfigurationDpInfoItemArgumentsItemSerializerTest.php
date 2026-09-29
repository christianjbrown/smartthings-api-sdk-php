<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItem;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemArgumentsItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItem::class)]
#[CoversClass(DeviceConfigurationDpInfoItemArgumentsItemSerializer::class)]
final class DeviceConfigurationDpInfoItemArgumentsItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new DeviceConfigurationDpInfoItemArgumentsItem('test-key', 'test-value');

        $serializer = new DeviceConfigurationDpInfoItemArgumentsItemSerializer();

        self::assertSame(
            [
                DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface::KEY_KEY => 'test-key',
                DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface::KEY_VALUE => 'test-value',
            ],
            $serializer->serialize($model)
        );
    }
}
