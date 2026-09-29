<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
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

use function sprintf;

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
    #[DataProvider('provideTransformUnexpectedCases')]
    public function testTransformUnexpected(array $data, string $message): void
    {
        $transformer = new HubDeviceDetailsTransformer(self::createStub(HubDriverTransformerInterface::class), self::createStub(HubDeviceDetailsHubDataTransformerInterface::class));

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage($message);
        $transformer->transform($data);
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string}>
     */
    public static function provideTransformUnexpectedCases(): iterable
    {
        yield 'hubEuiAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_EUI)];
        yield 'hubEuiWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 42], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_EUI)];
        yield 'firmwareVersionAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION)];
        yield 'firmwareVersionWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 42], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION)];
        yield 'hubDriversAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS)];
        yield 'hubDriversWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => 'not-array'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS)];
        yield 'hubDataAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_DATA)];
        yield 'hubDataWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id', HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => 'not-array'], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_HUB_DATA)];
        yield 'driverIdAbsent' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested']], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID)];
        yield 'driverIdWrongType' => [[HubDeviceDetailsTransformerInterface::KEY_HUB_EUI => 'test-hub-eui', HubDeviceDetailsTransformerInterface::KEY_FIRMWARE_VERSION => 'test-firmware-version', HubDeviceDetailsTransformerInterface::KEY_HUB_DRIVERS => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_HUB_DATA => ['test-nested'], HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], sprintf(HubDeviceDetailsTransformerInterface::UNEXPECTED_STRING_SPRINTF, HubDeviceDetailsTransformerInterface::KEY_DRIVER_ID)];
    }
}
