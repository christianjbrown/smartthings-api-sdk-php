<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\DriverDetails;
use ChristianBrown\SmartThings\Model\DriverFingerprintInterface;
use ChristianBrown\SmartThings\Model\DriverPermissionInterface;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverPermissionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverDetails::class)]
#[CoversClass(DriverDetailsTransformer::class)]
final class DriverDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $driverPermissionModel = self::createStub(DriverPermissionInterface::class);
        $driverPermissionTransformer = self::createStub(DriverPermissionTransformerInterface::class);
        $driverPermissionTransformer->method('transform')->willReturn($driverPermissionModel);
        $driverFingerprintModel = self::createStub(DriverFingerprintInterface::class);
        $driverFingerprintTransformer = self::createStub(DriverFingerprintTransformerInterface::class);
        $driverFingerprintTransformer->method('transform')->willReturn($driverFingerprintModel);
        $data = [
            DriverDetailsTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILES => [['test-nested']],
            DriverDetailsTransformerInterface::KEY_PERMISSIONS => [['test-nested']],
            DriverDetailsTransformerInterface::KEY_FINGERPRINTS => [['test-nested']],
        ];

        $transformer = new DriverDetailsTransformer($deviceIntegrationProfileKeyTransformer, $driverPermissionTransformer, $driverFingerprintTransformer);

        $actual = $transformer->transform($data);

        self::assertSame([$deviceIntegrationProfileKeyModel], $actual->getDeviceIntegrationProfiles());
        self::assertSame([$driverPermissionModel], $actual->getPermissions());
        self::assertSame([$driverFingerprintModel], $actual->getFingerprints());
    }

    public function testTransformDeviceIntegrationProfiles(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $driverPermissionModel = self::createStub(DriverPermissionInterface::class);
        $driverPermissionTransformer = self::createStub(DriverPermissionTransformerInterface::class);
        $driverPermissionTransformer->method('transform')->willReturn($driverPermissionModel);
        $driverFingerprintModel = self::createStub(DriverFingerprintInterface::class);
        $driverFingerprintTransformer = self::createStub(DriverFingerprintTransformerInterface::class);
        $driverFingerprintTransformer->method('transform')->willReturn($driverFingerprintModel);
        $transformer = new DriverDetailsTransformer($deviceIntegrationProfileKeyTransformer, $driverPermissionTransformer, $driverFingerprintTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceIntegrationProfiles());
        self::assertNull($transformer->transform($base + [DriverDetailsTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILES => 'test-not-array'])->getDeviceIntegrationProfiles());
        self::assertSame([$deviceIntegrationProfileKeyModel], $transformer->transform($base + [DriverDetailsTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILES => [['test-nested'], 'test-skipped']])->getDeviceIntegrationProfiles());
    }

    public function testTransformFingerprints(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $driverPermissionModel = self::createStub(DriverPermissionInterface::class);
        $driverPermissionTransformer = self::createStub(DriverPermissionTransformerInterface::class);
        $driverPermissionTransformer->method('transform')->willReturn($driverPermissionModel);
        $driverFingerprintModel = self::createStub(DriverFingerprintInterface::class);
        $driverFingerprintTransformer = self::createStub(DriverFingerprintTransformerInterface::class);
        $driverFingerprintTransformer->method('transform')->willReturn($driverFingerprintModel);
        $transformer = new DriverDetailsTransformer($deviceIntegrationProfileKeyTransformer, $driverPermissionTransformer, $driverFingerprintTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getFingerprints());
        self::assertNull($transformer->transform($base + [DriverDetailsTransformerInterface::KEY_FINGERPRINTS => 'test-not-array'])->getFingerprints());
        self::assertSame([$driverFingerprintModel], $transformer->transform($base + [DriverDetailsTransformerInterface::KEY_FINGERPRINTS => [['test-nested'], 'test-skipped']])->getFingerprints());
    }

    public function testTransformPermissions(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $driverPermissionModel = self::createStub(DriverPermissionInterface::class);
        $driverPermissionTransformer = self::createStub(DriverPermissionTransformerInterface::class);
        $driverPermissionTransformer->method('transform')->willReturn($driverPermissionModel);
        $driverFingerprintModel = self::createStub(DriverFingerprintInterface::class);
        $driverFingerprintTransformer = self::createStub(DriverFingerprintTransformerInterface::class);
        $driverFingerprintTransformer->method('transform')->willReturn($driverFingerprintModel);
        $transformer = new DriverDetailsTransformer($deviceIntegrationProfileKeyTransformer, $driverPermissionTransformer, $driverFingerprintTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getPermissions());
        self::assertNull($transformer->transform($base + [DriverDetailsTransformerInterface::KEY_PERMISSIONS => 'test-not-array'])->getPermissions());
        self::assertSame([$driverPermissionModel], $transformer->transform($base + [DriverDetailsTransformerInterface::KEY_PERMISSIONS => [['test-nested'], 'test-skipped']])->getPermissions());
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $driverPermissionModel = self::createStub(DriverPermissionInterface::class);
        $driverPermissionTransformer = self::createStub(DriverPermissionTransformerInterface::class);
        $driverPermissionTransformer->method('transform')->willReturn($driverPermissionModel);
        $driverFingerprintModel = self::createStub(DriverFingerprintInterface::class);
        $driverFingerprintTransformer = self::createStub(DriverFingerprintTransformerInterface::class);
        $driverFingerprintTransformer->method('transform')->willReturn($driverFingerprintModel);
        $transformer = new DriverDetailsTransformer($deviceIntegrationProfileKeyTransformer, $driverPermissionTransformer, $driverFingerprintTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDeviceIntegrationProfiles());
        self::assertNull($actual->getPermissions());
        self::assertNull($actual->getFingerprints());
    }
}
