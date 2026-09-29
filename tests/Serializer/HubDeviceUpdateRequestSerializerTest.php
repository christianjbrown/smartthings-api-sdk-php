<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Serializer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKey;
use ChristianBrown\SmartThings\Model\HubDeviceUpdateRequest;
use ChristianBrown\SmartThings\Serializer\HubDeviceUpdateRequestSerializer;
use ChristianBrown\SmartThings\Serializer\HubDeviceUpdateRequestSerializerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DeviceIntegrationProfileKey::class)]
#[CoversClass(HubDeviceUpdateRequest::class)]
#[CoversClass(HubDeviceUpdateRequestSerializer::class)]
final class HubDeviceUpdateRequestSerializerTest extends TestCase
{
    public function testSerializeOmitsUnsetOptionals(): void
    {
        $request = new HubDeviceUpdateRequest('test-driver-id');

        $serializer = new HubDeviceUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                HubDeviceUpdateRequestSerializerInterface::KEY_DRIVER_ID => 'test-driver-id',
            ],
            $actual
        );
    }

    public function testSerializeWithAllFieldsSet(): void
    {
        $request = (new HubDeviceUpdateRequest('test-driver-id'))
            ->setDeviceIntegrationProfileKey((new DeviceIntegrationProfileKey())
                ->setId('test-id')
                ->setMajorVersion(7))
            ->setProvisioningState('test-provisioning-state');

        $serializer = new HubDeviceUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                HubDeviceUpdateRequestSerializerInterface::KEY_DRIVER_ID => 'test-driver-id',
                HubDeviceUpdateRequestSerializerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => [
                    HubDeviceUpdateRequestSerializerInterface::KEY_ID => 'test-id',
                    HubDeviceUpdateRequestSerializerInterface::KEY_MAJOR_VERSION => 7,
                ],
                HubDeviceUpdateRequestSerializerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            ],
            $actual
        );
    }

    public function testSerializeWithOptionalsSetToDepth1(): void
    {
        $request = (new HubDeviceUpdateRequest('test-driver-id'))
            ->setDeviceIntegrationProfileKey(new DeviceIntegrationProfileKey())
            ->setProvisioningState('test-provisioning-state');

        $serializer = new HubDeviceUpdateRequestSerializer();

        $actual = $serializer->serialize($request);

        self::assertSame(
            [
                HubDeviceUpdateRequestSerializerInterface::KEY_DRIVER_ID => 'test-driver-id',
                HubDeviceUpdateRequestSerializerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => [],
                HubDeviceUpdateRequestSerializerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            ],
            $actual
        );
    }
}
