<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ZwaveDeviceDetails;
use ChristianBrown\SmartThings\Transformer\ZwaveDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZwaveDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZwaveDeviceDetails::class)]
#[CoversClass(ZwaveDeviceDetailsTransformer::class)]
final class ZwaveDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            ZwaveDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            ZwaveDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            ZwaveDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 'test-network-security-level',
            ZwaveDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            ZwaveDeviceDetailsTransformerInterface::KEY_MANUFACTURER_ID => 7,
            ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_TYPE => 7,
            ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 7,
            ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new ZwaveDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-network-id', $actual->getNetworkId());
        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-network-security-level', $actual->getNetworkSecurityLevel());
        self::assertSame('test-provisioning-state', $actual->getProvisioningState());
        self::assertSame(7, $actual->getManufacturerId());
        self::assertSame(7, $actual->getProductType());
        self::assertSame(7, $actual->getProductId());
        self::assertSame('test-fingerprint-type', $actual->getFingerprintType());
        self::assertSame('test-fingerprint-id', $actual->getFingerprintId());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new ZwaveDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'networkSecurityLevelAbsent' => [[], 'getNetworkSecurityLevel', null];
        yield 'networkSecurityLevelWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 42], 'getNetworkSecurityLevel', null];
        yield 'networkSecurityLevelValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_NETWORK_SECURITY_LEVEL => 'test-network-security-level'], 'getNetworkSecurityLevel', 'test-network-security-level'];
        yield 'provisioningStateAbsent' => [[], 'getProvisioningState', null];
        yield 'provisioningStateWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 42], 'getProvisioningState', null];
        yield 'provisioningStateValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state'], 'getProvisioningState', 'test-provisioning-state'];
        yield 'manufacturerIdAbsent' => [[], 'getManufacturerId', null];
        yield 'manufacturerIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_MANUFACTURER_ID => 'not-int'], 'getManufacturerId', null];
        yield 'manufacturerIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_MANUFACTURER_ID => 7], 'getManufacturerId', 7];
        yield 'productTypeAbsent' => [[], 'getProductType', null];
        yield 'productTypeWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_TYPE => 'not-int'], 'getProductType', null];
        yield 'productTypeValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_TYPE => 7], 'getProductType', 7];
        yield 'productIdAbsent' => [[], 'getProductId', null];
        yield 'productIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 'not-int'], 'getProductId', null];
        yield 'productIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 7], 'getProductId', 7];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[ZwaveDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ZwaveDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getNetworkSecurityLevel());
        self::assertNull($actual->getProvisioningState());
        self::assertNull($actual->getManufacturerId());
        self::assertNull($actual->getProductType());
        self::assertNull($actual->getProductId());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }
}
