<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\ZigbeeManufacturerFingerprint;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZigbeeManufacturerFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeManufacturerFingerprintTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZigbeeManufacturerFingerprint::class)]
#[CoversClass(ZigbeeManufacturerFingerprintTransformer::class)]
final class ZigbeeManufacturerFingerprintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $data = [
            ZigbeeManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER => 'test-manufacturer',
            ZigbeeManufacturerFingerprintTransformerInterface::KEY_MODEL => 'test-model',
            ZigbeeManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested'],
        ];

        $transformer = new ZigbeeManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-manufacturer', $actual->getManufacturer());
        self::assertSame('test-model', $actual->getModel());
        self::assertSame($deviceIntegrationProfileKeyModel, $actual->getDeviceIntegrationProfileKey());
    }

    public function testTransformDeviceIntegrationProfileKey(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZigbeeManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceIntegrationProfileKey());
        self::assertNull($transformer->transform($base + [ZigbeeManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => 'test-not-array'])->getDeviceIntegrationProfileKey());
        self::assertSame($deviceIntegrationProfileKeyModel, $transformer->transform($base + [ZigbeeManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested']])->getDeviceIntegrationProfileKey());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ZigbeeManufacturerFingerprintTransformer(self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'manufacturerAbsent' => [[], 'getManufacturer', null];
        yield 'manufacturerWrongType' => [[ZigbeeManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER => 42], 'getManufacturer', null];
        yield 'manufacturerValid' => [[ZigbeeManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER => 'test-manufacturer'], 'getManufacturer', 'test-manufacturer'];
        yield 'modelAbsent' => [[], 'getModel', null];
        yield 'modelWrongType' => [[ZigbeeManufacturerFingerprintTransformerInterface::KEY_MODEL => 42], 'getModel', null];
        yield 'modelValid' => [[ZigbeeManufacturerFingerprintTransformerInterface::KEY_MODEL => 'test-model'], 'getModel', 'test-model'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZigbeeManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getManufacturer());
        self::assertNull($actual->getModel());
        self::assertNull($actual->getDeviceIntegrationProfileKey());
    }
}
