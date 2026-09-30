<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetails;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataInterface;
use ChristianBrown\SmartThings\Model\HubDriverInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubDeviceDetails::class)]
#[CoversClass(HubDeviceDetailsTransformer::class)]
final class HubDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $hubDriverModel = self::createStub(HubDriverInterface::class);
        $hubDriverTransformer = self::createStub(HubDriverTransformerInterface::class);
        $hubDriverTransformer->method('transform')->willReturn($hubDriverModel);
        $hubDeviceDetailsHubDataModel = self::createStub(HubDeviceDetailsHubDataInterface::class);
        $hubDeviceDetailsHubDataTransformer = self::createStub(HubDeviceDetailsHubDataTransformerInterface::class);
        $hubDeviceDetailsHubDataTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataModel);
        $data = [
            HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui',
            HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version',
            HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => [['test-nested']],
            HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'],
            HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
        ];

        $transformer = new HubDeviceDetailsTransformer($hubDriverTransformer, $hubDeviceDetailsHubDataTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-hub-eui', $actual->getHubEui());
        self::assertSame('test-firmware-version', $actual->getFirmwareVersion());
        self::assertSame([$hubDriverModel], $actual->getHubDrivers());
        self::assertSame($hubDeviceDetailsHubDataModel, $actual->getHubData());
        self::assertSame('test-driver-id', $actual->getDriverId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new HubDeviceDetailsTransformer(self::createStub(HubDriverTransformerInterface::class), self::createStub(HubDeviceDetailsHubDataTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'hubEuiAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getHubEui', null];
        yield 'hubEuiWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 42], 'getHubEui', null];
        yield 'firmwareVersionAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getFirmwareVersion', null];
        yield 'firmwareVersionWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 42], 'getFirmwareVersion', null];
        yield 'hubDriversAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getHubDrivers', []];
        yield 'hubDriversWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => 'not-array'], 'getHubDrivers', []];
        yield 'hubDataAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getHubData', null];
        yield 'hubDataWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => 'not-array'], 'getHubData', null];
        yield 'driverIdAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested']], 'getDriverId', null];
        yield 'driverIdWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
    }
}
