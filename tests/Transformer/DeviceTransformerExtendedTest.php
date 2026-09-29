<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\AppDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\BleD2DDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\Device;
use ChristianBrown\SmartThings\Model\DeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\DeviceProfileReferenceInterface;
use ChristianBrown\SmartThings\Model\DeviceRelationshipInterface;
use ChristianBrown\SmartThings\Model\DthDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\EdgeChildDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\GroupDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\IdLessHealthStateInterface;
use ChristianBrown\SmartThings\Model\IndoorMapInterface;
use ChristianBrown\SmartThings\Model\IrDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\LanDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\MatterDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\MqttDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\OcfDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\ViperDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\VirtualDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\ZigbeeDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\ZwaveDeviceDetailsInterface;
use ChristianBrown\SmartThings\Transformer\DeviceComponentsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceDetailsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\DeviceTransformer;
use ChristianBrown\SmartThings\Transformer\DeviceTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Device::class)]
#[CoversClass(DeviceTransformer::class)]
final class DeviceTransformerExtendedTest extends TestCase
{
    /**
     * Each new plain field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformExtendedFieldsCases')]
    public function testTransformExtendedFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), self::createStub(DeviceDetailsTransformerInterface::class));

        $actual = $transformer->transform([DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformExtendedFieldsCases(): iterable
    {
        yield 'manufacturerNameAbsent' => [[], 'getManufacturerName', null];
        yield 'manufacturerNameWrongType' => [[DeviceTransformerInterface::KEY_MANUFACTURER_NAME => 42], 'getManufacturerName', null];
        yield 'manufacturerNameValid' => [[DeviceTransformerInterface::KEY_MANUFACTURER_NAME => 'test-manufacturer-name'], 'getManufacturerName', 'test-manufacturer-name'];
        yield 'presentationIdAbsent' => [[], 'getPresentationId', null];
        yield 'presentationIdWrongType' => [[DeviceTransformerInterface::KEY_PRESENTATION_ID => 42], 'getPresentationId', null];
        yield 'presentationIdValid' => [[DeviceTransformerInterface::KEY_PRESENTATION_ID => 'test-presentation-id'], 'getPresentationId', 'test-presentation-id'];
        yield 'deviceManufacturerCodeAbsent' => [[], 'getDeviceManufacturerCode', null];
        yield 'deviceManufacturerCodeWrongType' => [[DeviceTransformerInterface::KEY_DEVICE_MANUFACTURER_CODE => 42], 'getDeviceManufacturerCode', null];
        yield 'deviceManufacturerCodeValid' => [[DeviceTransformerInterface::KEY_DEVICE_MANUFACTURER_CODE => 'test-device-manufacturer-code'], 'getDeviceManufacturerCode', 'test-device-manufacturer-code'];
        yield 'ownerIdAbsent' => [[], 'getOwnerId', null];
        yield 'ownerIdWrongType' => [[DeviceTransformerInterface::KEY_OWNER_ID => 42], 'getOwnerId', null];
        yield 'ownerIdValid' => [[DeviceTransformerInterface::KEY_OWNER_ID => 'test-owner-id'], 'getOwnerId', 'test-owner-id'];
        yield 'deviceTypeIdAbsent' => [[], 'getDeviceTypeId', null];
        yield 'deviceTypeIdWrongType' => [[DeviceTransformerInterface::KEY_DEVICE_TYPE_ID => 42], 'getDeviceTypeId', null];
        yield 'deviceTypeIdValid' => [[DeviceTransformerInterface::KEY_DEVICE_TYPE_ID => 'test-device-type-id'], 'getDeviceTypeId', 'test-device-type-id'];
        yield 'deviceTypeNameAbsent' => [[], 'getDeviceTypeName', null];
        yield 'deviceTypeNameWrongType' => [[DeviceTransformerInterface::KEY_DEVICE_TYPE_NAME => 42], 'getDeviceTypeName', null];
        yield 'deviceTypeNameValid' => [[DeviceTransformerInterface::KEY_DEVICE_TYPE_NAME => 'test-device-type-name'], 'getDeviceTypeName', 'test-device-type-name'];
        yield 'deviceNetworkTypeAbsent' => [[], 'getDeviceNetworkType', null];
        yield 'deviceNetworkTypeWrongType' => [[DeviceTransformerInterface::KEY_DEVICE_NETWORK_TYPE => 42], 'getDeviceNetworkType', null];
        yield 'deviceNetworkTypeValid' => [[DeviceTransformerInterface::KEY_DEVICE_NETWORK_TYPE => 'test-device-network-type'], 'getDeviceNetworkType', 'test-device-network-type'];
        yield 'productIdAbsent' => [[], 'getProductId', null];
        yield 'productIdWrongType' => [[DeviceTransformerInterface::KEY_PRODUCT_ID => 42], 'getProductId', null];
        yield 'productIdValid' => [[DeviceTransformerInterface::KEY_PRODUCT_ID => 'test-product-id'], 'getProductId', 'test-product-id'];
        yield 'brandIdAbsent' => [[], 'getBrandId', null];
        yield 'brandIdWrongType' => [[DeviceTransformerInterface::KEY_BRAND_ID => 42], 'getBrandId', null];
        yield 'brandIdValid' => [[DeviceTransformerInterface::KEY_BRAND_ID => 'test-brand-id'], 'getBrandId', 'test-brand-id'];
        yield 'createTimeAbsent' => [[], 'getCreateTime', null];
        yield 'createTimeWrongType' => [[DeviceTransformerInterface::KEY_CREATE_TIME => 42], 'getCreateTime', null];
        yield 'createTimeValid' => [[DeviceTransformerInterface::KEY_CREATE_TIME => 'test-create-time'], 'getCreateTime', 'test-create-time'];
        yield 'parentDeviceIdAbsent' => [[], 'getParentDeviceId', null];
        yield 'parentDeviceIdWrongType' => [[DeviceTransformerInterface::KEY_PARENT_DEVICE_ID => 42], 'getParentDeviceId', null];
        yield 'parentDeviceIdValid' => [[DeviceTransformerInterface::KEY_PARENT_DEVICE_ID => 'test-parent-device-id'], 'getParentDeviceId', 'test-parent-device-id'];
        yield 'bleAbsent' => [[], 'getBle', []];
        yield 'bleWrongType' => [[DeviceTransformerInterface::KEY_BLE => 'not-array'], 'getBle', []];
        yield 'bleValid' => [[DeviceTransformerInterface::KEY_BLE => ['test-ble-key' => 'test-value']], 'getBle', ['test-ble-key' => 'test-value']];
        yield 'typeAbsent' => [[], 'getType', null];
        yield 'typeWrongType' => [[DeviceTransformerInterface::KEY_TYPE => 42], 'getType', null];
        yield 'typeValid' => [[DeviceTransformerInterface::KEY_TYPE => 'test-type'], 'getType', 'test-type'];
        yield 'restrictionTierAbsent' => [[], 'getRestrictionTier', null];
        yield 'restrictionTierWrongType' => [[DeviceTransformerInterface::KEY_RESTRICTION_TIER => 'not-int'], 'getRestrictionTier', null];
        yield 'restrictionTierValid' => [[DeviceTransformerInterface::KEY_RESTRICTION_TIER => 7], 'getRestrictionTier', 7];
        yield 'allowedAbsent' => [[], 'getAllowed', []];
        yield 'allowedWrongType' => [[DeviceTransformerInterface::KEY_ALLOWED => 'not-array'], 'getAllowed', []];
        yield 'allowedValid' => [[DeviceTransformerInterface::KEY_ALLOWED => ['test-allowed-1', 42, 'test-allowed-2']], 'getAllowed', ['test-allowed-1', 'test-allowed-2']];
        yield 'executionContextAbsent' => [[], 'getExecutionContext', null];
        yield 'executionContextWrongType' => [[DeviceTransformerInterface::KEY_EXECUTION_CONTEXT => 42], 'getExecutionContext', null];
        yield 'executionContextValid' => [[DeviceTransformerInterface::KEY_EXECUTION_CONTEXT => 'test-execution-context'], 'getExecutionContext', 'test-execution-context'];
    }

    public function testTransformExtendedNestedFields(): void
    {
        $healthState = self::createStub(IdLessHealthStateInterface::class);
        $profile = self::createStub(DeviceProfileReferenceInterface::class);
        $app = self::createStub(AppDeviceDetailsInterface::class);
        $bleD2D = self::createStub(BleD2DDeviceDetailsInterface::class);
        $dth = self::createStub(DthDeviceDetailsInterface::class);
        $lan = self::createStub(LanDeviceDetailsInterface::class);
        $zigbee = self::createStub(ZigbeeDeviceDetailsInterface::class);
        $zwave = self::createStub(ZwaveDeviceDetailsInterface::class);
        $matter = self::createStub(MatterDeviceDetailsInterface::class);
        $hub = self::createStub(HubDeviceDetailsInterface::class);
        $edgeChild = self::createStub(EdgeChildDeviceDetailsInterface::class);
        $ir = self::createStub(IrDeviceDetailsInterface::class);
        $irOcf = self::createStub(IrDeviceDetailsInterface::class);
        $ocf = self::createStub(OcfDeviceDetailsInterface::class);
        $viper = self::createStub(ViperDeviceDetailsInterface::class);
        $group = self::createStub(GroupDeviceDetailsInterface::class);
        $virtual = self::createStub(VirtualDeviceDetailsInterface::class);
        $mqtt = self::createStub(MqttDeviceDetailsInterface::class);
        $indoorMap = self::createStub(IndoorMapInterface::class);
        $relationships = [self::createStub(DeviceRelationshipInterface::class)];
        $details = self::createStub(DeviceDetailsInterface::class);
        $details->method('getHealthState')->willReturn($healthState);
        $details->method('getProfile')->willReturn($profile);
        $details->method('getApp')->willReturn($app);
        $details->method('getBleD2D')->willReturn($bleD2D);
        $details->method('getDth')->willReturn($dth);
        $details->method('getLan')->willReturn($lan);
        $details->method('getZigbee')->willReturn($zigbee);
        $details->method('getZwave')->willReturn($zwave);
        $details->method('getMatter')->willReturn($matter);
        $details->method('getHub')->willReturn($hub);
        $details->method('getEdgeChild')->willReturn($edgeChild);
        $details->method('getIr')->willReturn($ir);
        $details->method('getIrOcf')->willReturn($irOcf);
        $details->method('getOcf')->willReturn($ocf);
        $details->method('getViper')->willReturn($viper);
        $details->method('getGroup')->willReturn($group);
        $details->method('getVirtual')->willReturn($virtual);
        $details->method('getMqtt')->willReturn($mqtt);
        $details->method('getIndoorMap')->willReturn($indoorMap);
        $details->method('getRelationships')->willReturn($relationships);

        $data = [DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'] + [DeviceTransformerInterface::KEY_HEALTH_STATE => []];
        $containerTransformer = self::createMock(DeviceDetailsTransformerInterface::class);
        $containerTransformer->expects(self::once())->method('transform')
            ->with($data)
            ->willReturn($details);

        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($healthState, $actual->getHealthState());
        self::assertSame($profile, $actual->getProfile());
        self::assertSame($app, $actual->getApp());
        self::assertSame($bleD2D, $actual->getBleD2D());
        self::assertSame($dth, $actual->getDth());
        self::assertSame($lan, $actual->getLan());
        self::assertSame($zigbee, $actual->getZigbee());
        self::assertSame($zwave, $actual->getZwave());
        self::assertSame($matter, $actual->getMatter());
        self::assertSame($hub, $actual->getHub());
        self::assertSame($edgeChild, $actual->getEdgeChild());
        self::assertSame($ir, $actual->getIr());
        self::assertSame($irOcf, $actual->getIrOcf());
        self::assertSame($ocf, $actual->getOcf());
        self::assertSame($viper, $actual->getViper());
        self::assertSame($group, $actual->getGroup());
        self::assertSame($virtual, $actual->getVirtual());
        self::assertSame($mqtt, $actual->getMqtt());
        self::assertSame($indoorMap, $actual->getIndoorMap());
        self::assertSame($relationships, $actual->getRelationships());
    }

    public function testTransformExtendedNestedFieldsAbsent(): void
    {
        $details = self::createStub(DeviceDetailsInterface::class);
        $containerTransformer = self::createStub(DeviceDetailsTransformerInterface::class);
        $containerTransformer->method('transform')->willReturn($details);

        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform([DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id'] + [DeviceTransformerInterface::KEY_HEALTH_STATE => []]);

        self::assertNull($actual->getHealthState());
        self::assertNull($actual->getProfile());
        self::assertNull($actual->getApp());
        self::assertNull($actual->getBleD2D());
        self::assertNull($actual->getDth());
        self::assertNull($actual->getLan());
        self::assertNull($actual->getZigbee());
        self::assertNull($actual->getZwave());
        self::assertNull($actual->getMatter());
        self::assertNull($actual->getHub());
        self::assertNull($actual->getEdgeChild());
        self::assertNull($actual->getIr());
        self::assertNull($actual->getIrOcf());
        self::assertNull($actual->getOcf());
        self::assertNull($actual->getViper());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getVirtual());
        self::assertNull($actual->getMqtt());
        self::assertNull($actual->getIndoorMap());
        self::assertSame([], $actual->getRelationships());
    }

    public function testTransformExtendedSkipsTheContainerWithoutNestedKeys(): void
    {
        $containerTransformer = self::createMock(DeviceDetailsTransformerInterface::class);
        $containerTransformer->expects(self::never())->method('transform');

        $transformer = new DeviceTransformer(self::createStub(DeviceComponentsTransformerInterface::class), $containerTransformer);

        $actual = $transformer->transform([DeviceTransformerInterface::KEY_DEVICE_ID => 'test-device-id']);

        self::assertNull($actual->getHealthState());
        self::assertNull($actual->getProfile());
        self::assertNull($actual->getApp());
        self::assertNull($actual->getBleD2D());
        self::assertNull($actual->getDth());
        self::assertNull($actual->getLan());
        self::assertNull($actual->getZigbee());
        self::assertNull($actual->getZwave());
        self::assertNull($actual->getMatter());
        self::assertNull($actual->getHub());
        self::assertNull($actual->getEdgeChild());
        self::assertNull($actual->getIr());
        self::assertNull($actual->getIrOcf());
        self::assertNull($actual->getOcf());
        self::assertNull($actual->getViper());
        self::assertNull($actual->getGroup());
        self::assertNull($actual->getVirtual());
        self::assertNull($actual->getMqtt());
        self::assertNull($actual->getIndoorMap());
        self::assertSame([], $actual->getRelationships());
    }
}
