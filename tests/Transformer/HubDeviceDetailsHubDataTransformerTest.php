<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Tests\Transformer;

use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsInterface;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubData;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixInterface;
use ChristianBrown\SmartThings\Transformer\EdgeDriverSupportedEndpointAppsTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataTransformer;
use ChristianBrown\SmartThings\Transformer\HubDeviceDetailsHubDataTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(HubDeviceDetailsHubData::class)]
#[CoversClass(HubDeviceDetailsHubDataTransformer::class)]
final class HubDeviceDetailsHubDataTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $edgeDriverSupportedEndpointAppsModel = self::createStub(EdgeDriverSupportedEndpointAppsInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer = self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsModel);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixModel = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataHub2hubSupportMatrixModel);
        $data = [
            HubDeviceDetailsHubDataTransformerInterface::KEY_SERIAL_NUMBER => 'test-serial-number',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_STATIC_DSK => 'test-zwave-static-dsk',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type',
            HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_ID => 'test-hardware-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_FIRMWARE => 'test-zigbee-firmware',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_OTA => 'test-zigbee-ota',
            HubDeviceDetailsHubDataTransformerInterface::KEY_OTA_ENABLE => 'test-ota-enable',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_FAILOVER_AVAILABILITY => 'test-failover-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_SUPPORT_AVAILABILITY => 'test-primary-support-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_SECONDARY_SUPPORT_AVAILABILITY => 'test-secondary-support-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_AVAILABILITY => 'test-zigbee-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_AVAILABILITY => 'test-zwave-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_AVAILABILITY => 'test-thread-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_LAN_AVAILABILITY => 'test-lan-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_AVAILABILITY => 'test-matter-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY => 'test-local-virtual-device-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_CHILD_DEVICE_AVAILABILITY => 'test-child-device-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVERS_AVAILABILITY => 'test-edge-drivers-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_REPLACE_AVAILABILITY => 'test-hub-replace-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_LOCAL_API_AVAILABILITY => 'test-hub-local-api-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS => ['test-nested'],
            HubDeviceDetailsHubDataTransformerInterface::KEY_REPEATER_REACHABILITY => 'test-repeater-reachability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_SOFTWARE_COMPONENT_VERSION => 'test-matter-software-component-version',
            HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY => 'test-matter-device-diagnostics-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY => 'test-zigbee-device-diagnostics-availability',
            HubDeviceDetailsHubDataTransformerInterface::KEY_HEDGE_TLS_CERTIFICATE => 'test-hedge-tls-certificate',
            HubDeviceDetailsHubDataTransformerInterface::KEY_HUB2HUB_SUPPORT_MATRIX => ['test-nested'],
            HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_HUB_DEVICE_ID => 'test-primary-hub-device-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_CHANNEL => 'test-zigbee-channel',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_PAN_ID => 'test-zigbee-pan-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_EUI => 'test-zigbee-eui',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_NODE_ID => 'test-zigbee-node-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_NODE_ID => 'test-zwave-node-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_HOME_ID => 'test-zwave-home-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_SUC_ID => 'test-zwave-suc-id',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_VERSION => 'test-zwave-version',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_REGION => 'test-zwave-region',
            HubDeviceDetailsHubDataTransformerInterface::KEY_MAC_ADDRESS => 'test-mac-address',
            HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_IP => 'test-local-ip',
            HubDeviceDetailsHubDataTransformerInterface::KEY_WIFI_SSID => 'test-wifi-ssid',
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_FUNCTIONAL => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_FUNCTIONAL => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_ENABLED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_ENABLED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_DETECTED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_DETECTED => true,
            HubDeviceDetailsHubDataTransformerInterface::KEY_ENROLLMENT_CHANNEL => 'test-enrollment-channel',
        ];

        $transformer = new HubDeviceDetailsHubDataTransformer($edgeDriverSupportedEndpointAppsTransformer, $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('test-serial-number', $actual->getSerialNumber());
        self::assertSame('test-zwave-static-dsk', $actual->getZwaveStaticDsk());
        self::assertTrue($actual->getZwaveS2());
        self::assertSame('test-hardware-type', $actual->getHardwareType());
        self::assertSame('test-hardware-id', $actual->getHardwareId());
        self::assertSame('test-zigbee-firmware', $actual->getZigbeeFirmware());
        self::assertTrue($actual->getZigbee3());
        self::assertSame('test-zigbee-ota', $actual->getZigbeeOta());
        self::assertSame('test-ota-enable', $actual->getOtaEnable());
        self::assertTrue($actual->getZigbeeUnsecureRejoin());
        self::assertTrue($actual->getZigbeeRequiresExternalHardware());
        self::assertTrue($actual->getThreadRequiresExternalHardware());
        self::assertSame('test-failover-availability', $actual->getFailoverAvailability());
        self::assertSame('test-primary-support-availability', $actual->getPrimarySupportAvailability());
        self::assertSame('test-secondary-support-availability', $actual->getSecondarySupportAvailability());
        self::assertSame('test-zigbee-availability', $actual->getZigbeeAvailability());
        self::assertSame('test-zwave-availability', $actual->getZwaveAvailability());
        self::assertSame('test-thread-availability', $actual->getThreadAvailability());
        self::assertSame('test-lan-availability', $actual->getLanAvailability());
        self::assertSame('test-matter-availability', $actual->getMatterAvailability());
        self::assertSame('test-local-virtual-device-availability', $actual->getLocalVirtualDeviceAvailability());
        self::assertSame('test-child-device-availability', $actual->getChildDeviceAvailability());
        self::assertSame('test-edge-drivers-availability', $actual->getEdgeDriversAvailability());
        self::assertSame('test-hub-replace-availability', $actual->getHubReplaceAvailability());
        self::assertSame('test-hub-local-api-availability', $actual->getHubLocalApiAvailability());
        self::assertSame($edgeDriverSupportedEndpointAppsModel, $actual->getEdgeDriverSupportedEndpointApps());
        self::assertSame('test-repeater-reachability', $actual->getRepeaterReachability());
        self::assertTrue($actual->getZigbeeManualFirmwareUpdateSupported());
        self::assertTrue($actual->getMatterRendezvousHedgeSupported());
        self::assertSame('test-matter-software-component-version', $actual->getMatterSoftwareComponentVersion());
        self::assertSame('test-matter-device-diagnostics-availability', $actual->getMatterDeviceDiagnosticsAvailability());
        self::assertSame('test-zigbee-device-diagnostics-availability', $actual->getZigbeeDeviceDiagnosticsAvailability());
        self::assertSame('test-hedge-tls-certificate', $actual->getHedgeTlsCertificate());
        self::assertSame($hubDeviceDetailsHubDataHub2hubSupportMatrixModel, $actual->getHub2hubSupportMatrix());
        self::assertSame('test-primary-hub-device-id', $actual->getPrimaryHubDeviceId());
        self::assertSame('test-zigbee-channel', $actual->getZigbeeChannel());
        self::assertSame('test-zigbee-pan-id', $actual->getZigbeePanId());
        self::assertSame('test-zigbee-eui', $actual->getZigbeeEui());
        self::assertSame('test-zigbee-node-id', $actual->getZigbeeNodeID());
        self::assertSame('test-zwave-node-id', $actual->getZwaveNodeID());
        self::assertSame('test-zwave-home-id', $actual->getZwaveHomeID());
        self::assertSame('test-zwave-suc-id', $actual->getZwaveSucID());
        self::assertSame('test-zwave-version', $actual->getZwaveVersion());
        self::assertSame('test-zwave-region', $actual->getZwaveRegion());
        self::assertSame('test-mac-address', $actual->getMacAddress());
        self::assertSame('test-local-ip', $actual->getLocalIP());
        self::assertSame('test-wifi-ssid', $actual->getWifiSsid());
        self::assertTrue($actual->getZigbeeRadioFunctional());
        self::assertTrue($actual->getZwaveRadioFunctional());
        self::assertTrue($actual->getZigbeeRadioEnabled());
        self::assertTrue($actual->getZwaveRadioEnabled());
        self::assertTrue($actual->getZigbeeRadioDetected());
        self::assertTrue($actual->getZwaveRadioDetected());
        self::assertSame('test-enrollment-channel', $actual->getEnrollmentChannel());
    }

    public function testTransformEdgeDriverSupportedEndpointApps(): void
    {
        $edgeDriverSupportedEndpointAppsModel = self::createStub(EdgeDriverSupportedEndpointAppsInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer = self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsModel);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixModel = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataHub2hubSupportMatrixModel);
        $transformer = new HubDeviceDetailsHubDataTransformer($edgeDriverSupportedEndpointAppsTransformer, $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer);
        $base = [HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true];

        self::assertNull($transformer->transform($base)->getEdgeDriverSupportedEndpointApps());
        self::assertNull($transformer->transform($base + [HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS => 'test-not-array'])->getEdgeDriverSupportedEndpointApps());
        self::assertSame($edgeDriverSupportedEndpointAppsModel, $transformer->transform($base + [HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS => ['test-nested']])->getEdgeDriverSupportedEndpointApps());
    }

    public function testTransformHub2hubSupportMatrix(): void
    {
        $edgeDriverSupportedEndpointAppsModel = self::createStub(EdgeDriverSupportedEndpointAppsInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer = self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsModel);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixModel = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataHub2hubSupportMatrixModel);
        $transformer = new HubDeviceDetailsHubDataTransformer($edgeDriverSupportedEndpointAppsTransformer, $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer);
        $base = [HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true];

        self::assertNull($transformer->transform($base)->getHub2hubSupportMatrix());
        self::assertNull($transformer->transform($base + [HubDeviceDetailsHubDataTransformerInterface::KEY_HUB2HUB_SUPPORT_MATRIX => 'test-not-array'])->getHub2hubSupportMatrix());
        self::assertSame($hubDeviceDetailsHubDataHub2hubSupportMatrixModel, $transformer->transform($base + [HubDeviceDetailsHubDataTransformerInterface::KEY_HUB2HUB_SUPPORT_MATRIX => ['test-nested']])->getHub2hubSupportMatrix());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformLenientCases')]
    public function testTransformLenient(array $data, string $getter, mixed $expected): void
    {
        $transformer = new HubDeviceDetailsHubDataTransformer(self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class), self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class));

        $actual = $transformer->transform($data);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformLenientCases(): iterable
    {
        yield 'zwaveS2Absent' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true], 'getZwaveS2', null];
        yield 'zwaveS2WrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => 'not-bool'], 'getZwaveS2', null];
        yield 'hardwareTypeAbsent' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true], 'getHardwareType', null];
        yield 'hardwareTypeWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 42], 'getHardwareType', null];
        yield 'zigbee3Absent' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true], 'getZigbee3', null];
        yield 'zigbee3WrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => 'not-bool'], 'getZigbee3', null];
        yield 'zigbeeUnsecureRejoinAbsent' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true], 'getZigbeeUnsecureRejoin', null];
        yield 'zigbeeUnsecureRejoinWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => 'not-bool'], 'getZigbeeUnsecureRejoin', null];
    }

    /**
     * Each optional field in each of its states: absent, present but the wrong type, or valid.
     *
     * @param array<string, mixed> $extra
     */
    #[DataProvider('provideTransformOptionalFieldsCases')]
    public function testTransformOptionalFields(array $extra, string $getter, mixed $expected): void
    {
        $transformer = new HubDeviceDetailsHubDataTransformer(self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class), self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class));

        $actual = $transformer->transform([HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true] + $extra);

        self::assertSame($expected, $actual->{$getter}());
    }

    /**
     * @return iterable<string, array{array<string, mixed>, string, mixed}>
     */
    public static function provideTransformOptionalFieldsCases(): iterable
    {
        yield 'serialNumberAbsent' => [[], 'getSerialNumber', null];
        yield 'serialNumberWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_SERIAL_NUMBER => 42], 'getSerialNumber', null];
        yield 'serialNumberValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_SERIAL_NUMBER => 'test-serial-number'], 'getSerialNumber', 'test-serial-number'];
        yield 'zwaveStaticDskAbsent' => [[], 'getZwaveStaticDsk', null];
        yield 'zwaveStaticDskWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_STATIC_DSK => 42], 'getZwaveStaticDsk', null];
        yield 'zwaveStaticDskValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_STATIC_DSK => 'test-zwave-static-dsk'], 'getZwaveStaticDsk', 'test-zwave-static-dsk'];
        yield 'hardwareIdAbsent' => [[], 'getHardwareId', null];
        yield 'hardwareIdWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_ID => 42], 'getHardwareId', null];
        yield 'hardwareIdValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_ID => 'test-hardware-id'], 'getHardwareId', 'test-hardware-id'];
        yield 'zigbeeFirmwareAbsent' => [[], 'getZigbeeFirmware', null];
        yield 'zigbeeFirmwareWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_FIRMWARE => 42], 'getZigbeeFirmware', null];
        yield 'zigbeeFirmwareValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_FIRMWARE => 'test-zigbee-firmware'], 'getZigbeeFirmware', 'test-zigbee-firmware'];
        yield 'zigbeeOtaAbsent' => [[], 'getZigbeeOta', null];
        yield 'zigbeeOtaWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_OTA => 42], 'getZigbeeOta', null];
        yield 'zigbeeOtaValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_OTA => 'test-zigbee-ota'], 'getZigbeeOta', 'test-zigbee-ota'];
        yield 'otaEnableAbsent' => [[], 'getOtaEnable', null];
        yield 'otaEnableWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_OTA_ENABLE => 42], 'getOtaEnable', null];
        yield 'otaEnableValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_OTA_ENABLE => 'test-ota-enable'], 'getOtaEnable', 'test-ota-enable'];
        yield 'zigbeeRequiresExternalHardwareAbsent' => [[], 'getZigbeeRequiresExternalHardware', null];
        yield 'zigbeeRequiresExternalHardwareWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE => 'not-bool'], 'getZigbeeRequiresExternalHardware', null];
        yield 'zigbeeRequiresExternalHardwareValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE => true], 'getZigbeeRequiresExternalHardware', true];
        yield 'threadRequiresExternalHardwareAbsent' => [[], 'getThreadRequiresExternalHardware', null];
        yield 'threadRequiresExternalHardwareWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE => 'not-bool'], 'getThreadRequiresExternalHardware', null];
        yield 'threadRequiresExternalHardwareValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE => true], 'getThreadRequiresExternalHardware', true];
        yield 'failoverAvailabilityAbsent' => [[], 'getFailoverAvailability', null];
        yield 'failoverAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_FAILOVER_AVAILABILITY => 42], 'getFailoverAvailability', null];
        yield 'failoverAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_FAILOVER_AVAILABILITY => 'test-failover-availability'], 'getFailoverAvailability', 'test-failover-availability'];
        yield 'primarySupportAvailabilityAbsent' => [[], 'getPrimarySupportAvailability', null];
        yield 'primarySupportAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_SUPPORT_AVAILABILITY => 42], 'getPrimarySupportAvailability', null];
        yield 'primarySupportAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_SUPPORT_AVAILABILITY => 'test-primary-support-availability'], 'getPrimarySupportAvailability', 'test-primary-support-availability'];
        yield 'secondarySupportAvailabilityAbsent' => [[], 'getSecondarySupportAvailability', null];
        yield 'secondarySupportAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_SECONDARY_SUPPORT_AVAILABILITY => 42], 'getSecondarySupportAvailability', null];
        yield 'secondarySupportAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_SECONDARY_SUPPORT_AVAILABILITY => 'test-secondary-support-availability'], 'getSecondarySupportAvailability', 'test-secondary-support-availability'];
        yield 'zigbeeAvailabilityAbsent' => [[], 'getZigbeeAvailability', null];
        yield 'zigbeeAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_AVAILABILITY => 42], 'getZigbeeAvailability', null];
        yield 'zigbeeAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_AVAILABILITY => 'test-zigbee-availability'], 'getZigbeeAvailability', 'test-zigbee-availability'];
        yield 'zwaveAvailabilityAbsent' => [[], 'getZwaveAvailability', null];
        yield 'zwaveAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_AVAILABILITY => 42], 'getZwaveAvailability', null];
        yield 'zwaveAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_AVAILABILITY => 'test-zwave-availability'], 'getZwaveAvailability', 'test-zwave-availability'];
        yield 'threadAvailabilityAbsent' => [[], 'getThreadAvailability', null];
        yield 'threadAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_AVAILABILITY => 42], 'getThreadAvailability', null];
        yield 'threadAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_THREAD_AVAILABILITY => 'test-thread-availability'], 'getThreadAvailability', 'test-thread-availability'];
        yield 'lanAvailabilityAbsent' => [[], 'getLanAvailability', null];
        yield 'lanAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LAN_AVAILABILITY => 42], 'getLanAvailability', null];
        yield 'lanAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LAN_AVAILABILITY => 'test-lan-availability'], 'getLanAvailability', 'test-lan-availability'];
        yield 'matterAvailabilityAbsent' => [[], 'getMatterAvailability', null];
        yield 'matterAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_AVAILABILITY => 42], 'getMatterAvailability', null];
        yield 'matterAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_AVAILABILITY => 'test-matter-availability'], 'getMatterAvailability', 'test-matter-availability'];
        yield 'localVirtualDeviceAvailabilityAbsent' => [[], 'getLocalVirtualDeviceAvailability', null];
        yield 'localVirtualDeviceAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY => 42], 'getLocalVirtualDeviceAvailability', null];
        yield 'localVirtualDeviceAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY => 'test-local-virtual-device-availability'], 'getLocalVirtualDeviceAvailability', 'test-local-virtual-device-availability'];
        yield 'childDeviceAvailabilityAbsent' => [[], 'getChildDeviceAvailability', null];
        yield 'childDeviceAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_CHILD_DEVICE_AVAILABILITY => 42], 'getChildDeviceAvailability', null];
        yield 'childDeviceAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_CHILD_DEVICE_AVAILABILITY => 'test-child-device-availability'], 'getChildDeviceAvailability', 'test-child-device-availability'];
        yield 'edgeDriversAvailabilityAbsent' => [[], 'getEdgeDriversAvailability', null];
        yield 'edgeDriversAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVERS_AVAILABILITY => 42], 'getEdgeDriversAvailability', null];
        yield 'edgeDriversAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_EDGE_DRIVERS_AVAILABILITY => 'test-edge-drivers-availability'], 'getEdgeDriversAvailability', 'test-edge-drivers-availability'];
        yield 'hubReplaceAvailabilityAbsent' => [[], 'getHubReplaceAvailability', null];
        yield 'hubReplaceAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_REPLACE_AVAILABILITY => 42], 'getHubReplaceAvailability', null];
        yield 'hubReplaceAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_REPLACE_AVAILABILITY => 'test-hub-replace-availability'], 'getHubReplaceAvailability', 'test-hub-replace-availability'];
        yield 'hubLocalApiAvailabilityAbsent' => [[], 'getHubLocalApiAvailability', null];
        yield 'hubLocalApiAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_LOCAL_API_AVAILABILITY => 42], 'getHubLocalApiAvailability', null];
        yield 'hubLocalApiAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HUB_LOCAL_API_AVAILABILITY => 'test-hub-local-api-availability'], 'getHubLocalApiAvailability', 'test-hub-local-api-availability'];
        yield 'repeaterReachabilityAbsent' => [[], 'getRepeaterReachability', null];
        yield 'repeaterReachabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_REPEATER_REACHABILITY => 42], 'getRepeaterReachability', null];
        yield 'repeaterReachabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_REPEATER_REACHABILITY => 'test-repeater-reachability'], 'getRepeaterReachability', 'test-repeater-reachability'];
        yield 'zigbeeManualFirmwareUpdateSupportedAbsent' => [[], 'getZigbeeManualFirmwareUpdateSupported', null];
        yield 'zigbeeManualFirmwareUpdateSupportedWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED => 'not-bool'], 'getZigbeeManualFirmwareUpdateSupported', null];
        yield 'zigbeeManualFirmwareUpdateSupportedValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED => true], 'getZigbeeManualFirmwareUpdateSupported', true];
        yield 'matterRendezvousHedgeSupportedAbsent' => [[], 'getMatterRendezvousHedgeSupported', null];
        yield 'matterRendezvousHedgeSupportedWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED => 'not-bool'], 'getMatterRendezvousHedgeSupported', null];
        yield 'matterRendezvousHedgeSupportedValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED => true], 'getMatterRendezvousHedgeSupported', true];
        yield 'matterSoftwareComponentVersionAbsent' => [[], 'getMatterSoftwareComponentVersion', null];
        yield 'matterSoftwareComponentVersionWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_SOFTWARE_COMPONENT_VERSION => 42], 'getMatterSoftwareComponentVersion', null];
        yield 'matterSoftwareComponentVersionValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_SOFTWARE_COMPONENT_VERSION => 'test-matter-software-component-version'], 'getMatterSoftwareComponentVersion', 'test-matter-software-component-version'];
        yield 'matterDeviceDiagnosticsAvailabilityAbsent' => [[], 'getMatterDeviceDiagnosticsAvailability', null];
        yield 'matterDeviceDiagnosticsAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY => 42], 'getMatterDeviceDiagnosticsAvailability', null];
        yield 'matterDeviceDiagnosticsAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY => 'test-matter-device-diagnostics-availability'], 'getMatterDeviceDiagnosticsAvailability', 'test-matter-device-diagnostics-availability'];
        yield 'zigbeeDeviceDiagnosticsAvailabilityAbsent' => [[], 'getZigbeeDeviceDiagnosticsAvailability', null];
        yield 'zigbeeDeviceDiagnosticsAvailabilityWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY => 42], 'getZigbeeDeviceDiagnosticsAvailability', null];
        yield 'zigbeeDeviceDiagnosticsAvailabilityValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY => 'test-zigbee-device-diagnostics-availability'], 'getZigbeeDeviceDiagnosticsAvailability', 'test-zigbee-device-diagnostics-availability'];
        yield 'hedgeTlsCertificateAbsent' => [[], 'getHedgeTlsCertificate', null];
        yield 'hedgeTlsCertificateWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HEDGE_TLS_CERTIFICATE => 42], 'getHedgeTlsCertificate', null];
        yield 'hedgeTlsCertificateValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_HEDGE_TLS_CERTIFICATE => 'test-hedge-tls-certificate'], 'getHedgeTlsCertificate', 'test-hedge-tls-certificate'];
        yield 'primaryHubDeviceIdAbsent' => [[], 'getPrimaryHubDeviceId', null];
        yield 'primaryHubDeviceIdWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_HUB_DEVICE_ID => 42], 'getPrimaryHubDeviceId', null];
        yield 'primaryHubDeviceIdValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_PRIMARY_HUB_DEVICE_ID => 'test-primary-hub-device-id'], 'getPrimaryHubDeviceId', 'test-primary-hub-device-id'];
        yield 'zigbeeChannelAbsent' => [[], 'getZigbeeChannel', null];
        yield 'zigbeeChannelWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_CHANNEL => 42], 'getZigbeeChannel', null];
        yield 'zigbeeChannelValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_CHANNEL => 'test-zigbee-channel'], 'getZigbeeChannel', 'test-zigbee-channel'];
        yield 'zigbeePanIdAbsent' => [[], 'getZigbeePanId', null];
        yield 'zigbeePanIdWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_PAN_ID => 42], 'getZigbeePanId', null];
        yield 'zigbeePanIdValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_PAN_ID => 'test-zigbee-pan-id'], 'getZigbeePanId', 'test-zigbee-pan-id'];
        yield 'zigbeeEuiAbsent' => [[], 'getZigbeeEui', null];
        yield 'zigbeeEuiWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_EUI => 42], 'getZigbeeEui', null];
        yield 'zigbeeEuiValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_EUI => 'test-zigbee-eui'], 'getZigbeeEui', 'test-zigbee-eui'];
        yield 'zigbeeNodeIDAbsent' => [[], 'getZigbeeNodeID', null];
        yield 'zigbeeNodeIDWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_NODE_ID => 42], 'getZigbeeNodeID', null];
        yield 'zigbeeNodeIDValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_NODE_ID => 'test-zigbee-node-id'], 'getZigbeeNodeID', 'test-zigbee-node-id'];
        yield 'zwaveNodeIDAbsent' => [[], 'getZwaveNodeID', null];
        yield 'zwaveNodeIDWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_NODE_ID => 42], 'getZwaveNodeID', null];
        yield 'zwaveNodeIDValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_NODE_ID => 'test-zwave-node-id'], 'getZwaveNodeID', 'test-zwave-node-id'];
        yield 'zwaveHomeIDAbsent' => [[], 'getZwaveHomeID', null];
        yield 'zwaveHomeIDWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_HOME_ID => 42], 'getZwaveHomeID', null];
        yield 'zwaveHomeIDValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_HOME_ID => 'test-zwave-home-id'], 'getZwaveHomeID', 'test-zwave-home-id'];
        yield 'zwaveSucIDAbsent' => [[], 'getZwaveSucID', null];
        yield 'zwaveSucIDWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_SUC_ID => 42], 'getZwaveSucID', null];
        yield 'zwaveSucIDValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_SUC_ID => 'test-zwave-suc-id'], 'getZwaveSucID', 'test-zwave-suc-id'];
        yield 'zwaveVersionAbsent' => [[], 'getZwaveVersion', null];
        yield 'zwaveVersionWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_VERSION => 42], 'getZwaveVersion', null];
        yield 'zwaveVersionValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_VERSION => 'test-zwave-version'], 'getZwaveVersion', 'test-zwave-version'];
        yield 'zwaveRegionAbsent' => [[], 'getZwaveRegion', null];
        yield 'zwaveRegionWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_REGION => 42], 'getZwaveRegion', null];
        yield 'zwaveRegionValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_REGION => 'test-zwave-region'], 'getZwaveRegion', 'test-zwave-region'];
        yield 'macAddressAbsent' => [[], 'getMacAddress', null];
        yield 'macAddressWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MAC_ADDRESS => 42], 'getMacAddress', null];
        yield 'macAddressValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_MAC_ADDRESS => 'test-mac-address'], 'getMacAddress', 'test-mac-address'];
        yield 'localIPAbsent' => [[], 'getLocalIP', null];
        yield 'localIPWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_IP => 42], 'getLocalIP', null];
        yield 'localIPValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_LOCAL_IP => 'test-local-ip'], 'getLocalIP', 'test-local-ip'];
        yield 'wifiSsidAbsent' => [[], 'getWifiSsid', null];
        yield 'wifiSsidWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_WIFI_SSID => 42], 'getWifiSsid', null];
        yield 'wifiSsidValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_WIFI_SSID => 'test-wifi-ssid'], 'getWifiSsid', 'test-wifi-ssid'];
        yield 'zigbeeRadioFunctionalAbsent' => [[], 'getZigbeeRadioFunctional', null];
        yield 'zigbeeRadioFunctionalWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_FUNCTIONAL => 'not-bool'], 'getZigbeeRadioFunctional', null];
        yield 'zigbeeRadioFunctionalValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_FUNCTIONAL => true], 'getZigbeeRadioFunctional', true];
        yield 'zwaveRadioFunctionalAbsent' => [[], 'getZwaveRadioFunctional', null];
        yield 'zwaveRadioFunctionalWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_FUNCTIONAL => 'not-bool'], 'getZwaveRadioFunctional', null];
        yield 'zwaveRadioFunctionalValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_FUNCTIONAL => true], 'getZwaveRadioFunctional', true];
        yield 'zigbeeRadioEnabledAbsent' => [[], 'getZigbeeRadioEnabled', null];
        yield 'zigbeeRadioEnabledWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_ENABLED => 'not-bool'], 'getZigbeeRadioEnabled', null];
        yield 'zigbeeRadioEnabledValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_ENABLED => true], 'getZigbeeRadioEnabled', true];
        yield 'zwaveRadioEnabledAbsent' => [[], 'getZwaveRadioEnabled', null];
        yield 'zwaveRadioEnabledWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_ENABLED => 'not-bool'], 'getZwaveRadioEnabled', null];
        yield 'zwaveRadioEnabledValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_ENABLED => true], 'getZwaveRadioEnabled', true];
        yield 'zigbeeRadioDetectedAbsent' => [[], 'getZigbeeRadioDetected', null];
        yield 'zigbeeRadioDetectedWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_DETECTED => 'not-bool'], 'getZigbeeRadioDetected', null];
        yield 'zigbeeRadioDetectedValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_RADIO_DETECTED => true], 'getZigbeeRadioDetected', true];
        yield 'zwaveRadioDetectedAbsent' => [[], 'getZwaveRadioDetected', null];
        yield 'zwaveRadioDetectedWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_DETECTED => 'not-bool'], 'getZwaveRadioDetected', null];
        yield 'zwaveRadioDetectedValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_RADIO_DETECTED => true], 'getZwaveRadioDetected', true];
        yield 'enrollmentChannelAbsent' => [[], 'getEnrollmentChannel', null];
        yield 'enrollmentChannelWrongType' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ENROLLMENT_CHANNEL => 42], 'getEnrollmentChannel', null];
        yield 'enrollmentChannelValid' => [[HubDeviceDetailsHubDataTransformerInterface::KEY_ENROLLMENT_CHANNEL => 'test-enrollment-channel'], 'getEnrollmentChannel', 'test-enrollment-channel'];
    }

    public function testTransformRequiredFieldsOnly(): void
    {
        $edgeDriverSupportedEndpointAppsModel = self::createStub(EdgeDriverSupportedEndpointAppsInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer = self::createStub(EdgeDriverSupportedEndpointAppsTransformerInterface::class);
        $edgeDriverSupportedEndpointAppsTransformer->method('transform')->willReturn($edgeDriverSupportedEndpointAppsModel);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixModel = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer = self::createStub(HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface::class);
        $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer->method('transform')->willReturn($hubDeviceDetailsHubDataHub2hubSupportMatrixModel);
        $transformer = new HubDeviceDetailsHubDataTransformer($edgeDriverSupportedEndpointAppsTransformer, $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer);

        $actual = $transformer->transform([HubDeviceDetailsHubDataTransformerInterface::KEY_ZWAVE_S2 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_HARDWARE_TYPE => 'test-hardware-type', HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE3 => true, HubDeviceDetailsHubDataTransformerInterface::KEY_ZIGBEE_UNSECURE_REJOIN => true]);

        self::assertNull($actual->getSerialNumber());
        self::assertNull($actual->getZwaveStaticDsk());
        self::assertNull($actual->getHardwareId());
        self::assertNull($actual->getZigbeeFirmware());
        self::assertNull($actual->getZigbeeOta());
        self::assertNull($actual->getOtaEnable());
        self::assertNull($actual->getZigbeeRequiresExternalHardware());
        self::assertNull($actual->getThreadRequiresExternalHardware());
        self::assertNull($actual->getFailoverAvailability());
        self::assertNull($actual->getPrimarySupportAvailability());
        self::assertNull($actual->getSecondarySupportAvailability());
        self::assertNull($actual->getZigbeeAvailability());
        self::assertNull($actual->getZwaveAvailability());
        self::assertNull($actual->getThreadAvailability());
        self::assertNull($actual->getLanAvailability());
        self::assertNull($actual->getMatterAvailability());
        self::assertNull($actual->getLocalVirtualDeviceAvailability());
        self::assertNull($actual->getChildDeviceAvailability());
        self::assertNull($actual->getEdgeDriversAvailability());
        self::assertNull($actual->getHubReplaceAvailability());
        self::assertNull($actual->getHubLocalApiAvailability());
        self::assertNull($actual->getEdgeDriverSupportedEndpointApps());
        self::assertNull($actual->getRepeaterReachability());
        self::assertNull($actual->getZigbeeManualFirmwareUpdateSupported());
        self::assertNull($actual->getMatterRendezvousHedgeSupported());
        self::assertNull($actual->getMatterSoftwareComponentVersion());
        self::assertNull($actual->getMatterDeviceDiagnosticsAvailability());
        self::assertNull($actual->getZigbeeDeviceDiagnosticsAvailability());
        self::assertNull($actual->getHedgeTlsCertificate());
        self::assertNull($actual->getHub2hubSupportMatrix());
        self::assertNull($actual->getPrimaryHubDeviceId());
        self::assertNull($actual->getZigbeeChannel());
        self::assertNull($actual->getZigbeePanId());
        self::assertNull($actual->getZigbeeEui());
        self::assertNull($actual->getZigbeeNodeID());
        self::assertNull($actual->getZwaveNodeID());
        self::assertNull($actual->getZwaveHomeID());
        self::assertNull($actual->getZwaveSucID());
        self::assertNull($actual->getZwaveVersion());
        self::assertNull($actual->getZwaveRegion());
        self::assertNull($actual->getMacAddress());
        self::assertNull($actual->getLocalIP());
        self::assertNull($actual->getWifiSsid());
        self::assertNull($actual->getZigbeeRadioFunctional());
        self::assertNull($actual->getZwaveRadioFunctional());
        self::assertNull($actual->getZigbeeRadioEnabled());
        self::assertNull($actual->getZwaveRadioEnabled());
        self::assertNull($actual->getZigbeeRadioDetected());
        self::assertNull($actual->getZwaveRadioDetected());
        self::assertNull($actual->getEnrollmentChannel());
    }
}
