<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubData;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataInterface;

use function is_array;
use function is_bool;
use function is_string;

final class HubDeviceDetailsHubDataTransformer implements HubDeviceDetailsHubDataTransformerInterface
{
    private EdgeDriverSupportedEndpointAppsTransformerInterface $edgeDriverSupportedEndpointAppsTransformer;
    private HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer;

    public function __construct(EdgeDriverSupportedEndpointAppsTransformerInterface $edgeDriverSupportedEndpointAppsTransformer, HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer)
    {
        $this->edgeDriverSupportedEndpointAppsTransformer = $edgeDriverSupportedEndpointAppsTransformer;
        $this->hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer = $hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataInterface
    {
        $model = new HubDeviceDetailsHubData(self::requireZwaveS2($data), self::requireHardwareType($data), self::requireZigbee3($data), self::requireZigbeeUnsecureRejoin($data));

        self::applySerialNumber($model, $data);
        self::applyZwaveStaticDsk($model, $data);
        self::applyHardwareId($model, $data);
        self::applyZigbeeFirmware($model, $data);
        self::applyZigbeeOta($model, $data);
        self::applyOtaEnable($model, $data);
        self::applyZigbeeRequiresExternalHardware($model, $data);
        self::applyThreadRequiresExternalHardware($model, $data);
        self::applyFailoverAvailability($model, $data);
        self::applyPrimarySupportAvailability($model, $data);
        self::applySecondarySupportAvailability($model, $data);
        self::applyZigbeeAvailability($model, $data);
        self::applyZwaveAvailability($model, $data);
        self::applyThreadAvailability($model, $data);
        self::applyLanAvailability($model, $data);
        self::applyMatterAvailability($model, $data);
        self::applyLocalVirtualDeviceAvailability($model, $data);
        self::applyChildDeviceAvailability($model, $data);
        self::applyEdgeDriversAvailability($model, $data);
        self::applyHubReplaceAvailability($model, $data);
        self::applyHubLocalApiAvailability($model, $data);
        $this->applyEdgeDriverSupportedEndpointApps($model, $data);
        self::applyRepeaterReachability($model, $data);
        self::applyZigbeeManualFirmwareUpdateSupported($model, $data);
        self::applyMatterRendezvousHedgeSupported($model, $data);
        self::applyMatterSoftwareComponentVersion($model, $data);
        self::applyMatterDeviceDiagnosticsAvailability($model, $data);
        self::applyZigbeeDeviceDiagnosticsAvailability($model, $data);
        self::applyHedgeTlsCertificate($model, $data);
        $this->applyHub2hubSupportMatrix($model, $data);
        self::applyPrimaryHubDeviceId($model, $data);
        self::applyZigbeeChannel($model, $data);
        self::applyZigbeePanId($model, $data);
        self::applyZigbeeEui($model, $data);
        self::applyZigbeeNodeID($model, $data);
        self::applyZwaveNodeID($model, $data);
        self::applyZwaveHomeID($model, $data);
        self::applyZwaveSucID($model, $data);
        self::applyZwaveVersion($model, $data);
        self::applyZwaveRegion($model, $data);
        self::applyMacAddress($model, $data);
        self::applyLocalIP($model, $data);
        self::applyWifiSsid($model, $data);
        self::applyZigbeeRadioFunctional($model, $data);
        self::applyZwaveRadioFunctional($model, $data);
        self::applyZigbeeRadioEnabled($model, $data);
        self::applyZwaveRadioEnabled($model, $data);
        self::applyZigbeeRadioDetected($model, $data);
        self::applyZwaveRadioDetected($model, $data);
        self::applyEnrollmentChannel($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyChildDeviceAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_CHILD_DEVICE_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CHILD_DEVICE_AVAILABILITY])) {
            return;
        }
        $model->setChildDeviceAvailability($data[self::KEY_CHILD_DEVICE_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEdgeDriversAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_EDGE_DRIVERS_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_EDGE_DRIVERS_AVAILABILITY])) {
            return;
        }
        $model->setEdgeDriversAvailability($data[self::KEY_EDGE_DRIVERS_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEdgeDriverSupportedEndpointApps(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS])) {
            return;
        }
        if (!is_array($data[self::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS])) {
            return;
        }
        $model->setEdgeDriverSupportedEndpointApps($this->edgeDriverSupportedEndpointAppsTransformer->transform($data[self::KEY_EDGE_DRIVER_SUPPORTED_ENDPOINT_APPS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEnrollmentChannel(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ENROLLMENT_CHANNEL])) {
            return;
        }
        if (!is_string($data[self::KEY_ENROLLMENT_CHANNEL])) {
            return;
        }
        $model->setEnrollmentChannel($data[self::KEY_ENROLLMENT_CHANNEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyFailoverAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_FAILOVER_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_FAILOVER_AVAILABILITY])) {
            return;
        }
        $model->setFailoverAvailability($data[self::KEY_FAILOVER_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHardwareId(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_HARDWARE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_HARDWARE_ID])) {
            return;
        }
        $model->setHardwareId($data[self::KEY_HARDWARE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHedgeTlsCertificate(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_HEDGE_TLS_CERTIFICATE])) {
            return;
        }
        if (!is_string($data[self::KEY_HEDGE_TLS_CERTIFICATE])) {
            return;
        }
        $model->setHedgeTlsCertificate($data[self::KEY_HEDGE_TLS_CERTIFICATE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHub2hubSupportMatrix(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_HUB2HUB_SUPPORT_MATRIX])) {
            return;
        }
        if (!is_array($data[self::KEY_HUB2HUB_SUPPORT_MATRIX])) {
            return;
        }
        $model->setHub2hubSupportMatrix($this->hubDeviceDetailsHubDataHub2hubSupportMatrixTransformer->transform($data[self::KEY_HUB2HUB_SUPPORT_MATRIX]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubLocalApiAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_HUB_LOCAL_API_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_HUB_LOCAL_API_AVAILABILITY])) {
            return;
        }
        $model->setHubLocalApiAvailability($data[self::KEY_HUB_LOCAL_API_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHubReplaceAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_HUB_REPLACE_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_HUB_REPLACE_AVAILABILITY])) {
            return;
        }
        $model->setHubReplaceAvailability($data[self::KEY_HUB_REPLACE_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLanAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_LAN_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_LAN_AVAILABILITY])) {
            return;
        }
        $model->setLanAvailability($data[self::KEY_LAN_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalIP(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_LOCAL_IP])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCAL_IP])) {
            return;
        }
        $model->setLocalIP($data[self::KEY_LOCAL_IP]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLocalVirtualDeviceAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY])) {
            return;
        }
        $model->setLocalVirtualDeviceAvailability($data[self::KEY_LOCAL_VIRTUAL_DEVICE_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMacAddress(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_MAC_ADDRESS])) {
            return;
        }
        if (!is_string($data[self::KEY_MAC_ADDRESS])) {
            return;
        }
        $model->setMacAddress($data[self::KEY_MAC_ADDRESS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatterAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_MATTER_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_MATTER_AVAILABILITY])) {
            return;
        }
        $model->setMatterAvailability($data[self::KEY_MATTER_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatterDeviceDiagnosticsAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY])) {
            return;
        }
        $model->setMatterDeviceDiagnosticsAvailability($data[self::KEY_MATTER_DEVICE_DIAGNOSTICS_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatterRendezvousHedgeSupported(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED])) {
            return;
        }
        $model->setMatterRendezvousHedgeSupported($data[self::KEY_MATTER_RENDEZVOUS_HEDGE_SUPPORTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyMatterSoftwareComponentVersion(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_MATTER_SOFTWARE_COMPONENT_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_MATTER_SOFTWARE_COMPONENT_VERSION])) {
            return;
        }
        $model->setMatterSoftwareComponentVersion($data[self::KEY_MATTER_SOFTWARE_COMPONENT_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOtaEnable(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_OTA_ENABLE])) {
            return;
        }
        if (!is_string($data[self::KEY_OTA_ENABLE])) {
            return;
        }
        $model->setOtaEnable($data[self::KEY_OTA_ENABLE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrimaryHubDeviceId(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_PRIMARY_HUB_DEVICE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_PRIMARY_HUB_DEVICE_ID])) {
            return;
        }
        $model->setPrimaryHubDeviceId($data[self::KEY_PRIMARY_HUB_DEVICE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyPrimarySupportAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_PRIMARY_SUPPORT_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_PRIMARY_SUPPORT_AVAILABILITY])) {
            return;
        }
        $model->setPrimarySupportAvailability($data[self::KEY_PRIMARY_SUPPORT_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRepeaterReachability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_REPEATER_REACHABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_REPEATER_REACHABILITY])) {
            return;
        }
        $model->setRepeaterReachability($data[self::KEY_REPEATER_REACHABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySecondarySupportAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_SECONDARY_SUPPORT_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_SECONDARY_SUPPORT_AVAILABILITY])) {
            return;
        }
        $model->setSecondarySupportAvailability($data[self::KEY_SECONDARY_SUPPORT_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySerialNumber(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        if (!is_string($data[self::KEY_SERIAL_NUMBER])) {
            return;
        }
        $model->setSerialNumber($data[self::KEY_SERIAL_NUMBER]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyThreadAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_THREAD_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_THREAD_AVAILABILITY])) {
            return;
        }
        $model->setThreadAvailability($data[self::KEY_THREAD_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyThreadRequiresExternalHardware(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE])) {
            return;
        }
        if (!is_bool($data[self::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE])) {
            return;
        }
        $model->setThreadRequiresExternalHardware($data[self::KEY_THREAD_REQUIRES_EXTERNAL_HARDWARE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyWifiSsid(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_WIFI_SSID])) {
            return;
        }
        if (!is_string($data[self::KEY_WIFI_SSID])) {
            return;
        }
        $model->setWifiSsid($data[self::KEY_WIFI_SSID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_AVAILABILITY])) {
            return;
        }
        $model->setZigbeeAvailability($data[self::KEY_ZIGBEE_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeChannel(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_CHANNEL])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_CHANNEL])) {
            return;
        }
        $model->setZigbeeChannel($data[self::KEY_ZIGBEE_CHANNEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeDeviceDiagnosticsAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY])) {
            return;
        }
        $model->setZigbeeDeviceDiagnosticsAvailability($data[self::KEY_ZIGBEE_DEVICE_DIAGNOSTICS_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeEui(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_EUI])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_EUI])) {
            return;
        }
        $model->setZigbeeEui($data[self::KEY_ZIGBEE_EUI]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeFirmware(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_FIRMWARE])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_FIRMWARE])) {
            return;
        }
        $model->setZigbeeFirmware($data[self::KEY_ZIGBEE_FIRMWARE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeManualFirmwareUpdateSupported(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED])) {
            return;
        }
        $model->setZigbeeManualFirmwareUpdateSupported($data[self::KEY_ZIGBEE_MANUAL_FIRMWARE_UPDATE_SUPPORTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeNodeID(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_NODE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_NODE_ID])) {
            return;
        }
        $model->setZigbeeNodeID($data[self::KEY_ZIGBEE_NODE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeOta(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_OTA])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_OTA])) {
            return;
        }
        $model->setZigbeeOta($data[self::KEY_ZIGBEE_OTA]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeePanId(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZIGBEE_PAN_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ZIGBEE_PAN_ID])) {
            return;
        }
        $model->setZigbeePanId($data[self::KEY_ZIGBEE_PAN_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeRadioDetected(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_RADIO_DETECTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_RADIO_DETECTED])) {
            return;
        }
        $model->setZigbeeRadioDetected($data[self::KEY_ZIGBEE_RADIO_DETECTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeRadioEnabled(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_RADIO_ENABLED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_RADIO_ENABLED])) {
            return;
        }
        $model->setZigbeeRadioEnabled($data[self::KEY_ZIGBEE_RADIO_ENABLED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeRadioFunctional(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_RADIO_FUNCTIONAL])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_RADIO_FUNCTIONAL])) {
            return;
        }
        $model->setZigbeeRadioFunctional($data[self::KEY_ZIGBEE_RADIO_FUNCTIONAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZigbeeRequiresExternalHardware(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE])) {
            return;
        }
        $model->setZigbeeRequiresExternalHardware($data[self::KEY_ZIGBEE_REQUIRES_EXTERNAL_HARDWARE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveAvailability(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_AVAILABILITY])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_AVAILABILITY])) {
            return;
        }
        $model->setZwaveAvailability($data[self::KEY_ZWAVE_AVAILABILITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveHomeID(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_HOME_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_HOME_ID])) {
            return;
        }
        $model->setZwaveHomeID($data[self::KEY_ZWAVE_HOME_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveNodeID(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_NODE_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_NODE_ID])) {
            return;
        }
        $model->setZwaveNodeID($data[self::KEY_ZWAVE_NODE_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveRadioDetected(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE_RADIO_DETECTED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZWAVE_RADIO_DETECTED])) {
            return;
        }
        $model->setZwaveRadioDetected($data[self::KEY_ZWAVE_RADIO_DETECTED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveRadioEnabled(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE_RADIO_ENABLED])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZWAVE_RADIO_ENABLED])) {
            return;
        }
        $model->setZwaveRadioEnabled($data[self::KEY_ZWAVE_RADIO_ENABLED]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveRadioFunctional(HubDeviceDetailsHubData $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE_RADIO_FUNCTIONAL])) {
            return;
        }
        if (!is_bool($data[self::KEY_ZWAVE_RADIO_FUNCTIONAL])) {
            return;
        }
        $model->setZwaveRadioFunctional($data[self::KEY_ZWAVE_RADIO_FUNCTIONAL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveRegion(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_REGION])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_REGION])) {
            return;
        }
        $model->setZwaveRegion($data[self::KEY_ZWAVE_REGION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveStaticDsk(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_STATIC_DSK])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_STATIC_DSK])) {
            return;
        }
        $model->setZwaveStaticDsk($data[self::KEY_ZWAVE_STATIC_DSK]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveSucID(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_SUC_ID])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_SUC_ID])) {
            return;
        }
        $model->setZwaveSucID($data[self::KEY_ZWAVE_SUC_ID]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyZwaveVersion(HubDeviceDetailsHubData $model, array $data): void
    {
        if (empty($data[self::KEY_ZWAVE_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_ZWAVE_VERSION])) {
            return;
        }
        $model->setZwaveVersion($data[self::KEY_ZWAVE_VERSION]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireHardwareType(array $data): ?string
    {
        if (empty($data[self::KEY_HARDWARE_TYPE])) {
            return null;
        }
        if (!is_string($data[self::KEY_HARDWARE_TYPE])) {
            return null;
        }

        return $data[self::KEY_HARDWARE_TYPE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireZigbee3(array $data): ?bool
    {
        if (!isset($data[self::KEY_ZIGBEE3])) {
            return null;
        }
        if (!is_bool($data[self::KEY_ZIGBEE3])) {
            return null;
        }

        return $data[self::KEY_ZIGBEE3];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireZigbeeUnsecureRejoin(array $data): ?bool
    {
        if (!isset($data[self::KEY_ZIGBEE_UNSECURE_REJOIN])) {
            return null;
        }
        if (!is_bool($data[self::KEY_ZIGBEE_UNSECURE_REJOIN])) {
            return null;
        }

        return $data[self::KEY_ZIGBEE_UNSECURE_REJOIN];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireZwaveS2(array $data): ?bool
    {
        if (!isset($data[self::KEY_ZWAVE_S2])) {
            return null;
        }
        if (!is_bool($data[self::KEY_ZWAVE_S2])) {
            return null;
        }

        return $data[self::KEY_ZWAVE_S2];
    }
}
