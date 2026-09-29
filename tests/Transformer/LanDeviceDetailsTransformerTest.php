<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\LanDeviceDetails;
use ChristianBrown\SmartThings\Transformer\LanDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\LanDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(LanDeviceDetails::class)]
#[CoversClass(LanDeviceDetailsTransformer::class)]
final class LanDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            LanDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            LanDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            LanDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            LanDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            LanDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new LanDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

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
        $transformer = new LanDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[LanDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[LanDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[LanDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[LanDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'provisioningStateAbsent' => [[], 'getProvisioningState', null];
        yield 'provisioningStateWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 42], 'getProvisioningState', null];
        yield 'provisioningStateValid' => [[LanDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state'], 'getProvisioningState', 'test-provisioning-state'];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[LanDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new LanDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getProvisioningState());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }
}
