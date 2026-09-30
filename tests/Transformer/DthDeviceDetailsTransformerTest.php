<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\DthDeviceDetails;
use ChristianBrown\SmartThings\Transformer\DthDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\DthDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(DthDeviceDetails::class)]
#[CoversClass(DthDeviceDetailsTransformer::class)]
final class DthDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true,
            DthDeviceDetailsTransformerInterface::KEY_DEVICE_NETWORK_TYPE => 'test-device-network-type',
            DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id',
            DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name',
            DthDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            DthDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            DthDeviceDetailsTransformerInterface::KEY_INSTALLED_GROOVY_APP_ID => 'test-installed-groovy-app-id',
            DthDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            DthDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 'test-network-security-level',
            DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new DthDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertTrue($actual->getCompletedSetup());
        self::assertSame('test-device-network-type', $actual->getDeviceNetworkType());
        self::assertSame('test-device-type-id', $actual->getDeviceTypeId());
        self::assertSame('test-device-type-name', $actual->getDeviceTypeName());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-installed-groovy-app-id', $actual->getInstalledGroovyAppId());
        self::assertSame('test-network-id', $actual->getNetworkId());
        self::assertSame('test-network-security-level', $actual->getNetworkSecurityLevel());
        self::assertSame('test-fingerprint-type', $actual->getFingerprintType());
        self::assertSame('test-fingerprint-id', $actual->getFingerprintId());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new DthDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'completedSetupAbsent' => [[DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name'], 'getCompletedSetup', null];
        yield 'completedSetupWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name', DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => 'not-bool'], 'getCompletedSetup', null];
        yield 'deviceTypeIdAbsent' => [[DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name'], 'getDeviceTypeId', null];
        yield 'deviceTypeIdWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 42], 'getDeviceTypeId', null];
        yield 'deviceTypeNameAbsent' => [[DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id'], 'getDeviceTypeName', null];
        yield 'deviceTypeNameWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 42], 'getDeviceTypeName', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DthDeviceDetailsTransformer();

        $actual = $transformer->transform([DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'deviceNetworkTypeAbsent' => [[], 'getDeviceNetworkType', null];
        yield 'deviceNetworkTypeWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_DEVICE_NETWORK_TYPE => 42], 'getDeviceNetworkType', null];
        yield 'deviceNetworkTypeValid' => [[DthDeviceDetailsTransformerInterface::KEY_DEVICE_NETWORK_TYPE => 'test-device-network-type'], 'getDeviceNetworkType', 'test-device-network-type'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[DthDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[DthDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'installedGroovyAppIdAbsent' => [[], 'getInstalledGroovyAppId', null];
        yield 'installedGroovyAppIdWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_INSTALLED_GROOVY_APP_ID => 42], 'getInstalledGroovyAppId', null];
        yield 'installedGroovyAppIdValid' => [[DthDeviceDetailsTransformerInterface::KEY_INSTALLED_GROOVY_APP_ID => 'test-installed-groovy-app-id'], 'getInstalledGroovyAppId', 'test-installed-groovy-app-id'];
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[DthDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'networkSecurityLevelAbsent' => [[], 'getNetworkSecurityLevel', null];
        yield 'networkSecurityLevelWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 42], 'getNetworkSecurityLevel', null];
        yield 'networkSecurityLevelValid' => [[DthDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 'test-network-security-level'], 'getNetworkSecurityLevel', 'test-network-security-level'];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[DthDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new DthDeviceDetailsTransformer();

        $actual = $transformer->transform([DthDeviceDetailsTransformerInterface::KEY_COMPLETED_SETUP => true, DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id', DthDeviceDetailsTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name']);

        self::assertNull($actual->getDeviceNetworkType());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getInstalledGroovyAppId());
        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getNetworkSecurityLevel());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }
}
