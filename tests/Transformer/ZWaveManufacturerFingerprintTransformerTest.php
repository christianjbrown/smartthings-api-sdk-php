<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\ZWaveManufacturerFingerprint;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZWaveManufacturerFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZWaveManufacturerFingerprintTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZWaveManufacturerFingerprint::class)]
#[CoversClass(ZWaveManufacturerFingerprintTransformer::class)]
final class ZWaveManufacturerFingerprintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $data = [
            ZWaveManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER_ID => 7,
            ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_ID => 7,
            ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_TYPE => 7,
            ZWaveManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested'],
        ];

        $transformer = new ZWaveManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform($data);

        self::assertSame(7, $actual->getManufacturerId());
        self::assertSame(7, $actual->getProductId());
        self::assertSame(7, $actual->getProductType());
        self::assertSame($deviceIntegrationProfileKeyModel, $actual->getDeviceIntegrationProfileKey());
    }

    public function testTransformDeviceIntegrationProfileKey(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZWaveManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);
        $base = [ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_TYPE => 7];

        self::assertNull($transformer->transform($base)->getDeviceIntegrationProfileKey());
        self::assertNull($transformer->transform($base + [ZWaveManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => 'test-not-array'])->getDeviceIntegrationProfileKey());
        self::assertSame($deviceIntegrationProfileKeyModel, $transformer->transform($base + [ZWaveManufacturerFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested']])->getDeviceIntegrationProfileKey());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new ZWaveManufacturerFingerprintTransformer(self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'productTypeAbsent' => [[], 'getProductType', null];
        yield 'productTypeWrongType' => [[ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_TYPE => 'not-int'], 'getProductType', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ZWaveManufacturerFingerprintTransformer(self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class));

        $actual = $transformer->transform([ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_TYPE => 7] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'manufacturerIdAbsent' => [[], 'getManufacturerId', null];
        yield 'manufacturerIdWrongType' => [[ZWaveManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER_ID => 'not-int'], 'getManufacturerId', null];
        yield 'manufacturerIdValid' => [[ZWaveManufacturerFingerprintTransformerInterface::KEY_MANUFACTURER_ID => 7], 'getManufacturerId', 7];
        yield 'productIdAbsent' => [[], 'getProductId', null];
        yield 'productIdWrongType' => [[ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_ID => 'not-int'], 'getProductId', null];
        yield 'productIdValid' => [[ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_ID => 7], 'getProductId', 7];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZWaveManufacturerFingerprintTransformer($deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform([ZWaveManufacturerFingerprintTransformerInterface::KEY_PRODUCT_TYPE => 7]);

        self::assertNull($actual->getManufacturerId());
        self::assertNull($actual->getProductId());
        self::assertNull($actual->getDeviceIntegrationProfileKey());
    }
}
