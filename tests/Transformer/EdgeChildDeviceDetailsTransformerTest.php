<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EdgeChildDeviceDetails;
use ChristianBrown\SmartThings\Transformer\EdgeChildDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\EdgeChildDeviceDetailsTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(EdgeChildDeviceDetails::class)]
#[CoversClass(EdgeChildDeviceDetailsTransformer::class)]
final class EdgeChildDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            EdgeChildDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            EdgeChildDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            EdgeChildDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            EdgeChildDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            EdgeChildDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            EdgeChildDeviceDetailsTransformerInterface::KEY_PARENT_ASSIGNED_CHILD_KEY => 'test-parent-assigned-child-key',
            EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new EdgeChildDeviceDetailsTransformer();

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-provisioning-state', $actual->getProvisioningState());
        self::assertSame('test-network-id', $actual->getNetworkId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame('test-parent-assigned-child-key', $actual->getParentAssignedChildKey());
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
        $transformer = new EdgeChildDeviceDetailsTransformer();

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'provisioningStateAbsent' => [[], 'getProvisioningState', null];
        yield 'provisioningStateWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 42], 'getProvisioningState', null];
        yield 'provisioningStateValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state'], 'getProvisioningState', 'test-provisioning-state'];
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'parentAssignedChildKeyAbsent' => [[], 'getParentAssignedChildKey', null];
        yield 'parentAssignedChildKeyWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_PARENT_ASSIGNED_CHILD_KEY => 42], 'getParentAssignedChildKey', null];
        yield 'parentAssignedChildKeyValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_PARENT_ASSIGNED_CHILD_KEY => 'test-parent-assigned-child-key'], 'getParentAssignedChildKey', 'test-parent-assigned-child-key'];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[EdgeChildDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $transformer = new EdgeChildDeviceDetailsTransformer();

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getProvisioningState());
        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getParentAssignedChildKey());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }
}
