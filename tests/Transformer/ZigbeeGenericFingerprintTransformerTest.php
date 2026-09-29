<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ClustersInterface;
use ChristianBrown\SmartThings\Model\DeviceIntegrationProfileKeyInterface;
use ChristianBrown\SmartThings\Model\ZigbeeGenericFingerprint;
use ChristianBrown\SmartThings\Transformer\ClustersTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceIntegrationProfileKeyTransformerInterface;
use ChristianBrown\SmartThings\Transformer\ZigbeeGenericFingerprintTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeGenericFingerprintTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZigbeeGenericFingerprint::class)]
#[CoversClass(ZigbeeGenericFingerprintTransformer::class)]
final class ZigbeeGenericFingerprintTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $clustersModel = self::createStub(ClustersInterface::class);
        $clustersTransformer = self::createStub(ClustersTransformerInterface::class);
        $clustersTransformer->method('transform')->willReturn($clustersModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $data = [
            ZigbeeGenericFingerprintTransformerInterface::KEY_CLUSTERS => ['test-nested'],
            ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_IDENTIFIERS => [1, 2],
            ZigbeeGenericFingerprintTransformerInterface::KEY_ZIGBEE_PROFILES => [1, 2],
            ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested'],
        ];

        $transformer = new ZigbeeGenericFingerprintTransformer($clustersTransformer, $deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($clustersModel, $actual->getClusters());
        self::assertSame([1, 2], $actual->getDeviceIdentifiers());
        self::assertSame([1, 2], $actual->getZigbeeProfiles());
        self::assertSame($deviceIntegrationProfileKeyModel, $actual->getDeviceIntegrationProfileKey());
    }

    public function testTransformClusters(): void
    {
        $clustersModel = self::createStub(ClustersInterface::class);
        $clustersTransformer = self::createStub(ClustersTransformerInterface::class);
        $clustersTransformer->method('transform')->willReturn($clustersModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZigbeeGenericFingerprintTransformer($clustersTransformer, $deviceIntegrationProfileKeyTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getClusters());
        self::assertNull($transformer->transform($base + [ZigbeeGenericFingerprintTransformerInterface::KEY_CLUSTERS => 'test-not-array'])->getClusters());
        self::assertSame($clustersModel, $transformer->transform($base + [ZigbeeGenericFingerprintTransformerInterface::KEY_CLUSTERS => ['test-nested']])->getClusters());
    }

    public function testTransformDeviceIntegrationProfileKey(): void
    {
        $clustersModel = self::createStub(ClustersInterface::class);
        $clustersTransformer = self::createStub(ClustersTransformerInterface::class);
        $clustersTransformer->method('transform')->willReturn($clustersModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZigbeeGenericFingerprintTransformer($clustersTransformer, $deviceIntegrationProfileKeyTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getDeviceIntegrationProfileKey());
        self::assertNull($transformer->transform($base + [ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => 'test-not-array'])->getDeviceIntegrationProfileKey());
        self::assertSame($deviceIntegrationProfileKeyModel, $transformer->transform($base + [ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_INTEGRATION_PROFILE_KEY => ['test-nested']])->getDeviceIntegrationProfileKey());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ZigbeeGenericFingerprintTransformer(self::createStub(ClustersTransformerInterface::class), self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceIdentifiersAbsent' => [[], 'getDeviceIdentifiers', null];
        yield 'deviceIdentifiersWrongType' => [[ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_IDENTIFIERS => 'not-array'], 'getDeviceIdentifiers', null];
        yield 'deviceIdentifiersValid' => [[ZigbeeGenericFingerprintTransformerInterface::KEY_DEVICE_IDENTIFIERS => [1, 2]], 'getDeviceIdentifiers', [1, 2]];
        yield 'zigbeeProfilesAbsent' => [[], 'getZigbeeProfiles', null];
        yield 'zigbeeProfilesWrongType' => [[ZigbeeGenericFingerprintTransformerInterface::KEY_ZIGBEE_PROFILES => 'not-array'], 'getZigbeeProfiles', null];
        yield 'zigbeeProfilesValid' => [[ZigbeeGenericFingerprintTransformerInterface::KEY_ZIGBEE_PROFILES => [1, 2]], 'getZigbeeProfiles', [1, 2]];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $clustersModel = self::createStub(ClustersInterface::class);
        $clustersTransformer = self::createStub(ClustersTransformerInterface::class);
        $clustersTransformer->method('transform')->willReturn($clustersModel);
        $deviceIntegrationProfileKeyModel = self::createStub(DeviceIntegrationProfileKeyInterface::class);
        $deviceIntegrationProfileKeyTransformer = self::createStub(DeviceIntegrationProfileKeyTransformerInterface::class);
        $deviceIntegrationProfileKeyTransformer->method('transform')->willReturn($deviceIntegrationProfileKeyModel);
        $transformer = new ZigbeeGenericFingerprintTransformer($clustersTransformer, $deviceIntegrationProfileKeyTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getClusters());
        self::assertNull($actual->getDeviceIdentifiers());
        self::assertNull($actual->getZigbeeProfiles());
        self::assertNull($actual->getDeviceIntegrationProfileKey());
    }
}
