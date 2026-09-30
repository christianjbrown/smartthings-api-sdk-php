<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DriverFingerprint;
use ChristianBrown\SmartThings\Model\ZigbeeGenericFingerprintInterface;
use ChristianBrown\SmartThings\Model\ZigbeeManufacturerFingerprintInterface;
use ChristianBrown\SmartThings\Model\ZWaveGenericFingerprintInterface;
use ChristianBrown\SmartThings\Model\ZWaveManufacturerFingerprintInterface;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\DriverFingerprintTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZigbeeGenericFingerprintTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZigbeeManufacturerFingerprintTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZWaveGenericFingerprintTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZWaveManufacturerFingerprintTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DriverFingerprint::class)]
#[CoversClass(DriverFingerprintTransformer::class)]
final class DriverFingerprintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $data = [
            DriverFingerprintTransformerInterface::KEY_ID => 'test-id',
            DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type',
            DriverFingerprintTransformerInterface::KEY_DEVICE_LABEL => 'test-device-label',
            DriverFingerprintTransformerInterface::KEY_ZIGBEE_GENERIC => ['test-nested'],
            DriverFingerprintTransformerInterface::KEY_ZIGBEE_MANFACTURER => ['test-nested'],
            DriverFingerprintTransformerInterface::KEY_ZWAVE_MANUFACTURER => ['test-nested'],
            DriverFingerprintTransformerInterface::KEY_ZWAVE_GENERIC => ['test-nested'],
        ];

        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-id', $actual->getId());
        self::assertSame('test-type', $actual->getType());
        self::assertSame('test-device-label', $actual->getDeviceLabel());
        self::assertSame($zigbeeGenericFingerprintModel, $actual->getZigbeeGeneric());
        self::assertSame($zigbeeManufacturerFingerprintModel, $actual->getZigbeeManfacturer());
        self::assertSame($zWaveManufacturerFingerprintModel, $actual->getZwaveManufacturer());
        self::assertSame($zWaveGenericFingerprintModel, $actual->getZwaveGeneric());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DriverFingerprintTransformer(self::createStub(ZigbeeGenericFingerprintTransformerInterface::class), self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class), self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class), self::createStub(ZWaveGenericFingerprintTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'idAbsent' => [[DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'], 'getId', null];
        yield 'idWrongType' => [[DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type', DriverFingerprintTransformerInterface::KEY_ID => 42], 'getId', null];
        yield 'typeAbsent' => [[DriverFingerprintTransformerInterface::KEY_ID => 'test-id'], 'getType', null];
        yield 'typeWrongType' => [[DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 42], 'getType', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DriverFingerprintTransformer(self::createStub(ZigbeeGenericFingerprintTransformerInterface::class), self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class), self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class), self::createStub(ZWaveGenericFingerprintTransformerInterface::class));

        $actual = $transformer->transform([DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceLabelAbsent' => [[], 'getDeviceLabel', null];
        yield 'deviceLabelWrongType' => [[DriverFingerprintTransformerInterface::KEY_DEVICE_LABEL => 42], 'getDeviceLabel', null];
        yield 'deviceLabelValid' => [[DriverFingerprintTransformerInterface::KEY_DEVICE_LABEL => 'test-device-label'], 'getDeviceLabel', 'test-device-label'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);

        $actual = $transformer->transform([DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type']);

        self::assertNull($actual->getDeviceLabel());
        self::assertNull($actual->getZigbeeGeneric());
        self::assertNull($actual->getZigbeeManfacturer());
        self::assertNull($actual->getZwaveManufacturer());
        self::assertNull($actual->getZwaveGeneric());
    }

    public function testTransformZigbeeGeneric(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);
        $base = [DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getZigbeeGeneric());
        self::assertNull($transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZIGBEE_GENERIC => 'test-not-array'])->getZigbeeGeneric());
        self::assertSame($zigbeeGenericFingerprintModel, $transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZIGBEE_GENERIC => ['test-nested']])->getZigbeeGeneric());
    }

    public function testTransformZigbeeManfacturer(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);
        $base = [DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getZigbeeManfacturer());
        self::assertNull($transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZIGBEE_MANFACTURER => 'test-not-array'])->getZigbeeManfacturer());
        self::assertSame($zigbeeManufacturerFingerprintModel, $transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZIGBEE_MANFACTURER => ['test-nested']])->getZigbeeManfacturer());
    }

    public function testTransformZwaveGeneric(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);
        $base = [DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getZwaveGeneric());
        self::assertNull($transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZWAVE_GENERIC => 'test-not-array'])->getZwaveGeneric());
        self::assertSame($zWaveGenericFingerprintModel, $transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZWAVE_GENERIC => ['test-nested']])->getZwaveGeneric());
    }

    public function testTransformZwaveManufacturer(): void
    {
        $zigbeeGenericFingerprintModel = self::createStub(ZigbeeGenericFingerprintInterface::class);
        $zigbeeGenericFingerprintTransformer = self::createStub(ZigbeeGenericFingerprintTransformerInterface::class);
        $zigbeeGenericFingerprintTransformer->method('transform')->willReturn($zigbeeGenericFingerprintModel);
        $zigbeeManufacturerFingerprintModel = self::createStub(ZigbeeManufacturerFingerprintInterface::class);
        $zigbeeManufacturerFingerprintTransformer = self::createStub(ZigbeeManufacturerFingerprintTransformerInterface::class);
        $zigbeeManufacturerFingerprintTransformer->method('transform')->willReturn($zigbeeManufacturerFingerprintModel);
        $zWaveManufacturerFingerprintModel = self::createStub(ZWaveManufacturerFingerprintInterface::class);
        $zWaveManufacturerFingerprintTransformer = self::createStub(ZWaveManufacturerFingerprintTransformerInterface::class);
        $zWaveManufacturerFingerprintTransformer->method('transform')->willReturn($zWaveManufacturerFingerprintModel);
        $zWaveGenericFingerprintModel = self::createStub(ZWaveGenericFingerprintInterface::class);
        $zWaveGenericFingerprintTransformer = self::createStub(ZWaveGenericFingerprintTransformerInterface::class);
        $zWaveGenericFingerprintTransformer->method('transform')->willReturn($zWaveGenericFingerprintModel);
        $transformer = new DriverFingerprintTransformer($zigbeeGenericFingerprintTransformer, $zigbeeManufacturerFingerprintTransformer, $zWaveManufacturerFingerprintTransformer, $zWaveGenericFingerprintTransformer);
        $base = [DriverFingerprintTransformerInterface::KEY_ID => 'test-id', DriverFingerprintTransformerInterface::KEY_TYPE => 'test-type'];

        self::assertNull($transformer->transform($base)->getZwaveManufacturer());
        self::assertNull($transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZWAVE_MANUFACTURER => 'test-not-array'])->getZwaveManufacturer());
        self::assertSame($zWaveManufacturerFingerprintModel, $transformer->transform($base + [DriverFingerprintTransformerInterface::KEY_ZWAVE_MANUFACTURER => ['test-nested']])->getZwaveManufacturer());
    }
}
