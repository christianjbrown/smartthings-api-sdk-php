<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\MatterDeviceDetails;
use ChristianBrown\SmartThings\Model\MatterEndpointInterface;
use ChristianBrown\SmartThings\Model\MatterVersionInterface;
use ChristianBrown\SmartThings\Transformer\MatterDeviceDetailsTransformer;
use ChristianBrown\SmartThings\Transformer\MatterDeviceDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MatterEndpointTransformerInterface;
use ChristianBrown\SmartThings\Transformer\MatterVersionTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(MatterDeviceDetails::class)]
#[CoversClass(MatterDeviceDetailsTransformer::class)]
final class MatterDeviceDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $matterVersionModel = self::createStub(MatterVersionInterface::class);
        $matterVersionTransformer = self::createStub(MatterVersionTransformerInterface::class);
        $matterVersionTransformer->method('transform')->willReturn($matterVersionModel);
        $matterEndpointModel = self::createStub(MatterEndpointInterface::class);
        $matterEndpointTransformer = self::createStub(MatterEndpointTransformerInterface::class);
        $matterEndpointTransformer->method('transform')->willReturn($matterEndpointModel);
        $data = [
            MatterDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id',
            MatterDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id',
            MatterDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state',
            MatterDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id',
            MatterDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true,
            MatterDeviceDetailsTransformerInterface::KEY_UNIQUE_ID => 'test-unique-id',
            MatterDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 7,
            MatterDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 7,
            MatterDeviceDetailsTransformerInterface::KEY_SERIAL_NUMBER => 'test-serial-number',
            MatterDeviceDetailsTransformerInterface::KEY_LISTENING_TYPE => 'test-listening-type',
            MatterDeviceDetailsTransformerInterface::KEY_SUPPORTED_NETWORK_INTERFACES => ['test-supported-network-interfaces-1', 'test-supported-network-interfaces-2'],
            MatterDeviceDetailsTransformerInterface::KEY_VERSION => ['test-nested'],
            MatterDeviceDetailsTransformerInterface::KEY_ENDPOINTS => [['test-nested']],
            MatterDeviceDetailsTransformerInterface::KEY_SYNC_DRIVERS => true,
            MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type',
            MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id',
        ];

        $transformer = new MatterDeviceDetailsTransformer($matterVersionTransformer, $matterEndpointTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-driver-id', $actual->getDriverId());
        self::assertSame('test-hub-id', $actual->getHubId());
        self::assertSame('test-provisioning-state', $actual->getProvisioningState());
        self::assertSame('test-network-id', $actual->getNetworkId());
        self::assertTrue($actual->getExecutingLocally());
        self::assertSame('test-unique-id', $actual->getUniqueId());
        self::assertSame(7, $actual->getVendorId());
        self::assertSame(7, $actual->getProductId());
        self::assertSame('test-serial-number', $actual->getSerialNumber());
        self::assertSame('test-listening-type', $actual->getListeningType());
        self::assertSame(['test-supported-network-interfaces-1', 'test-supported-network-interfaces-2'], $actual->getSupportedNetworkInterfaces());
        self::assertSame($matterVersionModel, $actual->getVersion());
        self::assertSame([$matterEndpointModel], $actual->getEndpoints());
        self::assertTrue($actual->getSyncDrivers());
        self::assertSame('test-fingerprint-type', $actual->getFingerprintType());
        self::assertSame('test-fingerprint-id', $actual->getFingerprintId());
    }

    public function testTransformEndpoints(): void
    {
        $matterVersionModel = self::createStub(MatterVersionInterface::class);
        $matterVersionTransformer = self::createStub(MatterVersionTransformerInterface::class);
        $matterVersionTransformer->method('transform')->willReturn($matterVersionModel);
        $matterEndpointModel = self::createStub(MatterEndpointInterface::class);
        $matterEndpointTransformer = self::createStub(MatterEndpointTransformerInterface::class);
        $matterEndpointTransformer->method('transform')->willReturn($matterEndpointModel);
        $transformer = new MatterDeviceDetailsTransformer($matterVersionTransformer, $matterEndpointTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getEndpoints());
        self::assertNull($transformer->transform($base + [MatterDeviceDetailsTransformerInterface::KEY_ENDPOINTS => 'test-not-array'])->getEndpoints());
        self::assertSame([$matterEndpointModel], $transformer->transform($base + [MatterDeviceDetailsTransformerInterface::KEY_ENDPOINTS => [['test-nested'], 'test-skipped']])->getEndpoints());
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new MatterDeviceDetailsTransformer(self::createStub(MatterVersionTransformerInterface::class), self::createStub(MatterEndpointTransformerInterface::class));

        $actual = $transformer->transform([] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'driverIdAbsent' => [[], 'getDriverId', null];
        yield 'driverIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 42], 'getDriverId', null];
        yield 'driverIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_DRIVER_ID => 'test-driver-id'], 'getDriverId', 'test-driver-id'];
        yield 'hubIdAbsent' => [[], 'getHubId', null];
        yield 'hubIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_HUB_ID => 42], 'getHubId', null];
        yield 'hubIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_HUB_ID => 'test-hub-id'], 'getHubId', 'test-hub-id'];
        yield 'provisioningStateAbsent' => [[], 'getProvisioningState', null];
        yield 'provisioningStateWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 42], 'getProvisioningState', null];
        yield 'provisioningStateValid' => [[MatterDeviceDetailsTransformerInterface::KEY_PROVISIONING_STATE => 'test-provisioning-state'], 'getProvisioningState', 'test-provisioning-state'];
        yield 'networkIdAbsent' => [[], 'getNetworkId', null];
        yield 'networkIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 42], 'getNetworkId', null];
        yield 'networkIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_NETWORK_ID => 'test-network-id'], 'getNetworkId', 'test-network-id'];
        yield 'executingLocallyAbsent' => [[], 'getExecutingLocally', null];
        yield 'executingLocallyWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => 'not-bool'], 'getExecutingLocally', null];
        yield 'executingLocallyValid' => [[MatterDeviceDetailsTransformerInterface::KEY_EXECUTING_LOCALLY => true], 'getExecutingLocally', true];
        yield 'uniqueIdAbsent' => [[], 'getUniqueId', null];
        yield 'uniqueIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_UNIQUE_ID => 42], 'getUniqueId', null];
        yield 'uniqueIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_UNIQUE_ID => 'test-unique-id'], 'getUniqueId', 'test-unique-id'];
        yield 'vendorIdAbsent' => [[], 'getVendorId', null];
        yield 'vendorIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 'not-int'], 'getVendorId', null];
        yield 'vendorIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_VENDOR_ID => 7], 'getVendorId', 7];
        yield 'productIdAbsent' => [[], 'getProductId', null];
        yield 'productIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 'not-int'], 'getProductId', null];
        yield 'productIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_PRODUCT_ID => 7], 'getProductId', 7];
        yield 'serialNumberAbsent' => [[], 'getSerialNumber', null];
        yield 'serialNumberWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_SERIAL_NUMBER => 42], 'getSerialNumber', null];
        yield 'serialNumberValid' => [[MatterDeviceDetailsTransformerInterface::KEY_SERIAL_NUMBER => 'test-serial-number'], 'getSerialNumber', 'test-serial-number'];
        yield 'listeningTypeAbsent' => [[], 'getListeningType', null];
        yield 'listeningTypeWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_LISTENING_TYPE => 42], 'getListeningType', null];
        yield 'listeningTypeValid' => [[MatterDeviceDetailsTransformerInterface::KEY_LISTENING_TYPE => 'test-listening-type'], 'getListeningType', 'test-listening-type'];
        yield 'supportedNetworkInterfacesAbsent' => [[], 'getSupportedNetworkInterfaces', null];
        yield 'supportedNetworkInterfacesWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_SUPPORTED_NETWORK_INTERFACES => 'not-array'], 'getSupportedNetworkInterfaces', null];
        yield 'supportedNetworkInterfacesValid' => [[MatterDeviceDetailsTransformerInterface::KEY_SUPPORTED_NETWORK_INTERFACES => ['test-supported-network-interfaces-1', 'test-supported-network-interfaces-2']], 'getSupportedNetworkInterfaces', ['test-supported-network-interfaces-1', 'test-supported-network-interfaces-2']];
        yield 'syncDriversAbsent' => [[], 'getSyncDrivers', null];
        yield 'syncDriversWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_SYNC_DRIVERS => 'not-bool'], 'getSyncDrivers', null];
        yield 'syncDriversValid' => [[MatterDeviceDetailsTransformerInterface::KEY_SYNC_DRIVERS => true], 'getSyncDrivers', true];
        yield 'fingerprintTypeAbsent' => [[], 'getFingerprintType', null];
        yield 'fingerprintTypeWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 42], 'getFingerprintType', null];
        yield 'fingerprintTypeValid' => [[MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_TYPE => 'test-fingerprint-type'], 'getFingerprintType', 'test-fingerprint-type'];
        yield 'fingerprintIdAbsent' => [[], 'getFingerprintId', null];
        yield 'fingerprintIdWrongType' => [[MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 42], 'getFingerprintId', null];
        yield 'fingerprintIdValid' => [[MatterDeviceDetailsTransformerInterface::KEY_FINGERPRINT_ID => 'test-fingerprint-id'], 'getFingerprintId', 'test-fingerprint-id'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $matterVersionModel = self::createStub(MatterVersionInterface::class);
        $matterVersionTransformer = self::createStub(MatterVersionTransformerInterface::class);
        $matterVersionTransformer->method('transform')->willReturn($matterVersionModel);
        $matterEndpointModel = self::createStub(MatterEndpointInterface::class);
        $matterEndpointTransformer = self::createStub(MatterEndpointTransformerInterface::class);
        $matterEndpointTransformer->method('transform')->willReturn($matterEndpointModel);
        $transformer = new MatterDeviceDetailsTransformer($matterVersionTransformer, $matterEndpointTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getDriverId());
        self::assertNull($actual->getHubId());
        self::assertNull($actual->getProvisioningState());
        self::assertNull($actual->getNetworkId());
        self::assertNull($actual->getExecutingLocally());
        self::assertNull($actual->getUniqueId());
        self::assertNull($actual->getVendorId());
        self::assertNull($actual->getProductId());
        self::assertNull($actual->getSerialNumber());
        self::assertNull($actual->getListeningType());
        self::assertNull($actual->getSupportedNetworkInterfaces());
        self::assertNull($actual->getVersion());
        self::assertNull($actual->getEndpoints());
        self::assertNull($actual->getSyncDrivers());
        self::assertNull($actual->getFingerprintType());
        self::assertNull($actual->getFingerprintId());
    }

    public function testTransformVersion(): void
    {
        $matterVersionModel = self::createStub(MatterVersionInterface::class);
        $matterVersionTransformer = self::createStub(MatterVersionTransformerInterface::class);
        $matterVersionTransformer->method('transform')->willReturn($matterVersionModel);
        $matterEndpointModel = self::createStub(MatterEndpointInterface::class);
        $matterEndpointTransformer = self::createStub(MatterEndpointTransformerInterface::class);
        $matterEndpointTransformer->method('transform')->willReturn($matterEndpointModel);
        $transformer = new MatterDeviceDetailsTransformer($matterVersionTransformer, $matterEndpointTransformer);
        $base = [];

        self::assertNull($transformer->transform($base)->getVersion());
        self::assertNull($transformer->transform($base + [MatterDeviceDetailsTransformerInterface::KEY_VERSION => 'test-not-array'])->getVersion());
        self::assertSame($matterVersionModel, $transformer->transform($base + [MatterDeviceDetailsTransformerInterface::KEY_VERSION => ['test-nested']])->getVersion());
    }
}
