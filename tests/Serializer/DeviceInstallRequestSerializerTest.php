<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceInstallApp;
use ChristianBrown\SmartThings\Model\DeviceInstallRequest;
use ChristianBrown\SmartThings\Serializer\DeviceInstallRequestSerializer;
use ChristianBrown\SmartThings\Serializer\DeviceInstallRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceInstallApp::class)]
#[CoversClass(DeviceInstallRequest::class)]
#[CoversClass(DeviceInstallRequestSerializer::class)]
final class DeviceInstallRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new DeviceInstallRequest('test-location-id', new DeviceInstallApp('test-profile-id', 'test-installed-app-id'));

        $serializer = new DeviceInstallRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                DeviceInstallRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                DeviceInstallRequestSerializerInterface::KEY_APP => [
                    DeviceInstallRequestSerializerInterface::KEY_PROFILE_ID => 'test-profile-id',
                    DeviceInstallRequestSerializerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
                ],
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $app = (new DeviceInstallApp('test-profile-id', 'test-installed-app-id'))
            ->setExternalId('test-external-id');
        $request = (new DeviceInstallRequest('test-location-id', $app))
            ->setLabel('test-label')
            ->setRoomId('test-room-id');

        $serializer = new DeviceInstallRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                DeviceInstallRequestSerializerInterface::KEY_LOCATION_ID => 'test-location-id',
                DeviceInstallRequestSerializerInterface::KEY_LABEL => 'test-label',
                DeviceInstallRequestSerializerInterface::KEY_ROOM_ID => 'test-room-id',
                DeviceInstallRequestSerializerInterface::KEY_APP => [
                    DeviceInstallRequestSerializerInterface::KEY_PROFILE_ID => 'test-profile-id',
                    DeviceInstallRequestSerializerInterface::KEY_INSTALLED_APP_ID => 'test-installed-app-id',
                    DeviceInstallRequestSerializerInterface::KEY_EXTERNAL_ID => 'test-external-id',
                ],
            ],
            $actual
        );
    }
}
