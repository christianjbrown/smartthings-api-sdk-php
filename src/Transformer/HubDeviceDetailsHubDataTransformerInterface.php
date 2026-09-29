<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataInterface;

interface HubDeviceDetailsHubDataTransformerInterface
{
    public const string KEY_CHILD_DEVICE_AVAILABILITY = 'childDeviceAvailability';
    public const string KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS = 'edgeDriverSupportedEndpointApps';
    public const string KEY_EDGE_DRIVERS_AVAILABILITY = 'edgeDriversAvailability';
    public const string KEY_ENROLLMENT_CHANNEL = 'enrollmentChannel';
    public const string KEY_FAILOVER_AVAILABILITY = 'failoverAvailability';
    public const string KEY_HARDWARE_ID = 'hardwareId';
    public const string KEY_HARDWARE_TYPE = 'hardwareType';
    public const string KEY_HEDGE_TLS_CERTIFICATE = 'hedgeTlsCertificate';
    public const string KEY_HUB2HUB_SUPPORT_MATRIX = 'hub2hubSupportMatrix';
    public const string KEY_HUB_LOCAL_API_AVAILABILITY = 'hubLocalApiAvailability';
    public const string KEY_HUB_REPLACE_AVAILABILITY = 'hubReplaceAvailability';
    public const string KEY_LAN_AVAILABILITY = 'lanAvailability';
    public const string KEY_LOCAL_IP = 'localIP';
    public const string KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY = 'localVirtualDeviceAvailability';
    public const string KEY_MAC_ADDRESS = 'macAddress';
    public const string KEY_MATTER_AVAILABILITY = 'matterAvailability';
    public const string KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY = 'matterDeviceDiagnosticsAvailability';
    public const string KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED = 'matterRendezvousHedgeSupported';
    public const string KEY_MATTER_SOFTWARE_COMPONENT_VERSION = 'matterSoftwareComponentVersion';
    public const string KEY_OTA_ENABLE = 'otaEnable';
    public const string KEY_PRIMARY_HUB_DEVICE_ID = 'primaryHubDeviceId';
    public const string KEY_PRIMARY_SUPPORT_AVAILABILITY = 'primarySupportAvailability';
    public const string KEY_REPEATER_REACHABILITY = 'repeaterReachability';
    public const string KEY_SECONDARY_SUPPORT_AVAILABILITY = 'secondarySupportAvailability';
    public const string KEY_SERIAL_NUMBER = 'serialNumber';
    public const string KEY_THREAD_AVAILABILITY = 'threadAvailability';
    public const string KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE = 'threadRequiresExternalHardware';
    public const string KEY_WIFI_SSID = 'wifiSsid';
    public const string KEY_ZIGBEE3 = 'zigbee3';
    public const string KEY_ZIGBEE_AVAILABILITY = 'zigbeeAvailability';
    public const string KEY_ZIGBEE_CHANNEL = 'zigbeeChannel';
    public const string KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY = 'zigbeeDeviceDiagnosticsAvailability';
    public const string KEY_ZIGBEE_EUI = 'zigbeeEui';
    public const string KEY_ZIGBEE_FIRMWARE = 'zigbeeFirmware';
    public const string KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED = 'zigbeeManualFirmwareUpdateSupported';
    public const string KEY_ZIGBEE_NODE_ID = 'zigbeeNodeID';
    public const string KEY_ZIGBEE_OTA = 'zigbeeOta';
    public const string KEY_ZIGBEE_PAN_ID = 'zigbeePanId';
    public const string KEY_ZIGBEE_RADIO_DETECTED = 'zigbeeRadioDetected';
    public const string KEY_ZIGBEE_RADIO_ENABLED = 'zigbeeRadioEnabled';
    public const string KEY_ZIGBEE_RADIO_FUNCTIONAL = 'zigbeeRadioFunctional';
    public const string KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE = 'zigbeeRequiresExternalHardware';
    public const string KEY_ZIGBEE_UNSECURE_REJOIN = 'zigbeeUnsecureRejoin';
    public const string KEY_ZWAVE_AVAILABILITY = 'zwaveAvailability';
    public const string KEY_ZWAVE_HOME_ID = 'zwaveHomeID';
    public const string KEY_ZWAVE_NODE_ID = 'zwaveNodeID';
    public const string KEY_ZWAVE_RADIO_DETECTED = 'zwaveRadioDetected';
    public const string KEY_ZWAVE_RADIO_ENABLED = 'zwaveRadioEnabled';
    public const string KEY_ZWAVE_RADIO_FUNCTIONAL = 'zwaveRadioFunctional';
    public const string KEY_ZWAVE_REGION = 'zwaveRegion';
    public const string KEY_ZWAVE_S2 = 'zwaveS2';
    public const string KEY_ZWAVE_STATIC_DSK = 'zwaveStaticDsk';
    public const string KEY_ZWAVE_SUC_ID = 'zwaveSucID';
    public const string KEY_ZWAVE_VERSION = 'zwaveVersion';
    public const string UNEXPECTED_BOOL_SPRINTF = '%s not set or not a boolean';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataInterface;
}
