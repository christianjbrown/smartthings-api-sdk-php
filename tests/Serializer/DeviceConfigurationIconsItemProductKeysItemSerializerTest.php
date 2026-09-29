<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemProductKeysItem;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemProductKeysItemSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceConfigurationIconsItemProductKeysItemSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceConfigurationIconsItemProductKeysItem::class)]
#[CoversClass(DeviceConfigurationIconsItemProductKeysItemSerializer::class)]
final class DeviceConfigurationIconsItemProductKeysItemSerializerTest extends TestCase
{
    public function testSerializeRequiredFieldsOnly(): void
    {
        $model = new DeviceConfigurationIconsItemProductKeysItem('test-mn-id', 'test-setup-id');

        $serializer = new DeviceConfigurationIconsItemProductKeysItemSerializer();

        self::assertSame(
            [
                DeviceConfigurationIconsItemProductKeysItemSerializerInterface::KEY_MN_ID => 'test-mn-id',
                DeviceConfigurationIconsItemProductKeysItemSerializerInterface::KEY_SETUP_ID => 'test-setup-id',
            ],
            $serializer->serialize($model)
        );
    }
}
