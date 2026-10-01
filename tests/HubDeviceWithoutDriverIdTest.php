<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests;

use ChristianBrown\SmartThings\Api\ApiHost;
use ChristianBrown\SmartThings\SmartThingsFactory;
use ChristianBrown\SmartThings\SmartThingsInterface;
use ChristianBrown\SmartThings\Transformer\DevicesTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\TestCase;

/**
 * The vendor spec marks a hub block's driverId as required, but real hub devices omit it. Version
 * 2.0.0 threw on that and broke every device listing, so this pins the real transformer chain, wired
 * by the container exactly as the facade wires it, against a hub device without one.
 */
#[CoversNothing]
final class HubDeviceWithoutDriverIdTest extends TestCase
{
    public function testDevicesListWithHubMissingDriverId(): void
    {
        $container = (new SmartThingsFactory())->createContainer('test-token', new ApiHost());
        $transformer = $container->get(SmartThingsInterface::SERVICE_DEVICES_TRANSFORMER);
        self::assertInstanceOf(DevicesTransformerInterface::class, $transformer);

        $devices = $transformer->transform([
            [
                DeviceTransformerInterface::KEY_DEVICE_ID => 'test-hub-device-id',
                DeviceTransformerInterface::KEY_HUB => [
                    HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui',
                    HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version',
                    HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => [],
                    HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => [
                        HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true,
                        HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type',
                        HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true,
                        HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => false,
                    ],
                ],
            ],
        ]);

        self::assertCount(1, $devices);
        $hub = $devices[0]->getHub();
        self::assertNotNull($hub);
        self::assertNull($hub->getDriverId());
        self::assertSame('test-hub-eui', $hub->getHubEui());
        self::assertSame('test-firmware-version', $hub->getFirmwareVersion());
    }
}
