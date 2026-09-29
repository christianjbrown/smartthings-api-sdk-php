<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\ZigbeeDeviceDetails;
use ChristianBrown\SmartThings\Transformer\ZigbeeDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\ZigbeeDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ZigbeeDeviceDetails::class)]
#[CoversClass(ZigbeeDeviceDetailsTransformer::class)]
final class ZigbeeDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ZigbeeDeviceDetailsTransformerInterface::KEY_EUI => 'test-eui',
            ZigbeeDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            ZigbeeDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            ZigbeeDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            ZigbeeDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            ZigbeeDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new ZigbeeDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-eui', $actual->getEui());
        self::assertSame('test-network-id', $actual->getNetworkId());
        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-provisioning-state', $actual->getProvisioningState());
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
        $transformer = new ZigbeeDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'euiAbsent' => [[], 'getEui', null];
        yield 'euiWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_EUI => 42], 'getEui', null];
        yield 'euiValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_EUI => 'test-eui'], 'getEui', 'test-eui'];
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'provisioningStateAbsent' => [[], 'getProvisioningState', null];
        yield 'provisioningStateWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 42], 'getProvisioningState', null];
        yield 'provisioningStateValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state'], 'getProvisioningState', 'test-provisioning-state'];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[ZigbeeDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new ZigbeeDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getEui());
        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getProvisioningState());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }
}
