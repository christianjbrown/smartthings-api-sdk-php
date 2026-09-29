<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\Driver;
use ChristianBrown\SmartThings\Model\DriverDetailsInterface;
use ChristianBrown\SmartThings\Model\DriverFingerprintInterface;
use ChristianBrown\SmartThings\Model\DriverPermissionInterface;
use ChristianBrown\SmartThings\Transformer\DriverDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DriverTransformer;
use ChristianBrown\SmartThings\Transformer\DriverTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Driver::class)]
#[CoversClass(DriverTransformer::class)]
final class DriverTransformerExtendedTest extends TestCase
{
    public function testTransformExtendedNestedFields(): void
    {
        $deviceIntegrationProfiles = [self::createStub(DeviceIntegrationProfileKeyInterface::class)];
        $permissions = [self::createStub(DriverPermissionInterface::class)];
        $fingerprints = [self::createStub(DriverFingerprintInterface::class)];
        $details = self::createStub(DriverDetailsInterface::class);
        $details->method('getDeviceIntegrationProfiles')->willReturn($deviceIntegrationProfiles);
        $details->method('getPermissions')->willReturn($permissions);
        $details->method('getFingerprints')->willReturn($fingerprints);

        $data = [DriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'] + [DriverTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILES => []];
        $containerTransformer = self::createMock(DriverDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new DriverTransformer($containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($deviceIntegrationProfiles, $actual->getDeviceIntegrationProfiles());
        self::assertSame($permissions, $actual->getPermissions());
        self::assertSame($fingerprints, $actual->getFingerprints());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(DriverDetailsInterface::class);
        $containerTransformer = self::createStub(DriverDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new DriverTransformer($containerTransformer);

        $actual = $transformer->transform([DriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'] + [DriverTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILES => []]);

        self::assertSame([], $actual->getDeviceIntegrationProfiles());
        self::assertSame([], $actual->getPermissions());
        self::assertSame([], $actual->getFingerprints());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(DriverDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new DriverTransformer($containerTransformer);

        $actual = $transformer->transform([DriverTransformerInterface::KEY_DRIVER_ID => 'test-driver-id']);

        self::assertSame([], $actual->getDeviceIntegrationProfiles());
        self::assertSame([], $actual->getPermissions());
        self::assertSame([], $actual->getFingerprints());
    }
}
