<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubDeviceDetailsHubData implements HubDeviceDetailsHubDataInterface
{
    private ?string $childDeviceAvailability = null;
    private ?string $edgeDriversAvailability = null;
    private ?EdgeDriverSupportedEndpointAppsInterface $edgeDriverSupportedEndpointApps = null;
    private ?string $enrollmentChannel = null;
    private ?string $failoverAvailability = null;
    private ?string $hardwareId = null;
    private string $hardwareType;
    private ?string $hedgeTlsCertificate = null;
    private ?HubDeviceDetailsHubDataHub2hubSupportMatrixInterface $hub2hubSupportMatrix = null;
    private ?string $hubLocalApiAvailability = null;
    private ?string $hubReplaceAvailability = null;
    private ?string $lanAvailability = null;
    private ?string $localIP = null;
    private ?string $localVirtualDeviceAvailability = null;
    private ?string $macAddress = null;
    private ?string $matterAvailability = null;
    private ?string $matterDeviceDiagnosticsAvailability = null;
    private ?bool $matterRendezvousHedgeSupported = null;
    private ?string $matterSoftwareComponentVersion = null;
    private ?string $otaEnable = null;
    private ?string $primaryHubDeviceId = null;
    private ?string $primarySupportAvailability = null;
    private ?string $repeaterReachability = null;
    private ?string $secondarySupportAvailability = null;
    private ?string $serialNumber = null;
    private ?string $threadAvailability = null;
    private ?bool $threadRequiresExternalHardware = null;
    private ?string $wifiSsid = null;
    private bool $zigbee3;
    private ?string $zigbeeAvailability = null;
    private ?string $zigbeeChannel = null;
    private ?string $zigbeeDeviceDiagnosticsAvailability = null;
    private ?string $zigbeeEui = null;
    private ?string $zigbeeFirmware = null;
    private ?bool $zigbeeManualFirmwareUpdateSupported = null;
    private ?string $zigbeeNodeID = null;
    private ?string $zigbeeOta = null;
    private ?string $zigbeePanId = null;
    private ?bool $zigbeeRadioDetected = null;
    private ?bool $zigbeeRadioEnabled = null;
    private ?bool $zigbeeRadioFunctional = null;
    private ?bool $zigbeeRequiresExternalHardware = null;
    private bool $zigbeeUnsecureRejoin;
    private ?string $zwaveAvailability = null;
    private ?string $zwaveHomeID = null;
    private ?string $zwaveNodeID = null;
    private ?bool $zwaveRadioDetected = null;
    private ?bool $zwaveRadioEnabled = null;
    private ?bool $zwaveRadioFunctional = null;
    private ?string $zwaveRegion = null;
    private bool $zwaveS2;
    private ?string $zwaveStaticDsk = null;
    private ?string $zwaveSucID = null;
    private ?string $zwaveVersion = null;

    public function __construct(bool $zwaveS2, string $hardwareType, bool $zigbee3, bool $zigbeeUnsecureRejoin)
    {
        $this->zwaveS2 = $zwaveS2;
        $this->hardwareType = $hardwareType;
        $this->zigbee3 = $zigbee3;
        $this->zigbeeUnsecureRejoin = $zigbeeUnsecureRejoin;
    }

    public function getChildDeviceAvailability(): ?string
    {
        return $this->childDeviceAvailability;
    }

    public function getEdgeDriversAvailability(): ?string
    {
        return $this->edgeDriversAvailability;
    }

    public function getEdgeDriverSupportedEndpointApps(): ?EdgeDriverSupportedEndpointAppsInterface
    {
        return $this->edgeDriverSupportedEndpointApps;
    }

    public function getEnrollmentChannel(): ?string
    {
        return $this->enrollmentChannel;
    }

    public function getFailoverAvailability(): ?string
    {
        return $this->failoverAvailability;
    }

    public function getHardwareId(): ?string
    {
        return $this->hardwareId;
    }

    public function getHardwareType(): string
    {
        return $this->hardwareType;
    }

    public function getHedgeTlsCertificate(): ?string
    {
        return $this->hedgeTlsCertificate;
    }

    public function getHub2hubSupportMatrix(): ?HubDeviceDetailsHubDataHub2hubSupportMatrixInterface
    {
        return $this->hub2hubSupportMatrix;
    }

    public function getHubLocalApiAvailability(): ?string
    {
        return $this->hubLocalApiAvailability;
    }

    public function getHubReplaceAvailability(): ?string
    {
        return $this->hubReplaceAvailability;
    }

    public function getLanAvailability(): ?string
    {
        return $this->lanAvailability;
    }

    public function getLocalIP(): ?string
    {
        return $this->localIP;
    }

    public function getLocalVirtualDeviceAvailability(): ?string
    {
        return $this->localVirtualDeviceAvailability;
    }

    public function getMacAddress(): ?string
    {
        return $this->macAddress;
    }

    public function getMatterAvailability(): ?string
    {
        return $this->matterAvailability;
    }

    public function getMatterDeviceDiagnosticsAvailability(): ?string
    {
        return $this->matterDeviceDiagnosticsAvailability;
    }

    public function getMatterRendezvousHedgeSupported(): ?bool
    {
        return $this->matterRendezvousHedgeSupported;
    }

    public function getMatterSoftwareComponentVersion(): ?string
    {
        return $this->matterSoftwareComponentVersion;
    }

    public function getOtaEnable(): ?string
    {
        return $this->otaEnable;
    }

    public function getPrimaryHubDeviceId(): ?string
    {
        return $this->primaryHubDeviceId;
    }

    public function getPrimarySupportAvailability(): ?string
    {
        return $this->primarySupportAvailability;
    }

    public function getRepeaterReachability(): ?string
    {
        return $this->repeaterReachability;
    }

    public function getSecondarySupportAvailability(): ?string
    {
        return $this->secondarySupportAvailability;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
    }

    public function getThreadAvailability(): ?string
    {
        return $this->threadAvailability;
    }

    public function getThreadRequiresExternalHardware(): ?bool
    {
        return $this->threadRequiresExternalHardware;
    }

    public function getWifiSsid(): ?string
    {
        return $this->wifiSsid;
    }

    public function getZigbee3(): bool
    {
        return $this->zigbee3;
    }

    public function getZigbeeAvailability(): ?string
    {
        return $this->zigbeeAvailability;
    }

    public function getZigbeeChannel(): ?string
    {
        return $this->zigbeeChannel;
    }

    public function getZigbeeDeviceDiagnosticsAvailability(): ?string
    {
        return $this->zigbeeDeviceDiagnosticsAvailability;
    }

    public function getZigbeeEui(): ?string
    {
        return $this->zigbeeEui;
    }

    public function getZigbeeFirmware(): ?string
    {
        return $this->zigbeeFirmware;
    }

    public function getZigbeeManualFirmwareUpdateSupported(): ?bool
    {
        return $this->zigbeeManualFirmwareUpdateSupported;
    }

    public function getZigbeeNodeID(): ?string
    {
        return $this->zigbeeNodeID;
    }

    public function getZigbeeOta(): ?string
    {
        return $this->zigbeeOta;
    }

    public function getZigbeePanId(): ?string
    {
        return $this->zigbeePanId;
    }

    public function getZigbeeRadioDetected(): ?bool
    {
        return $this->zigbeeRadioDetected;
    }

    public function getZigbeeRadioEnabled(): ?bool
    {
        return $this->zigbeeRadioEnabled;
    }

    public function getZigbeeRadioFunctional(): ?bool
    {
        return $this->zigbeeRadioFunctional;
    }

    public function getZigbeeRequiresExternalHardware(): ?bool
    {
        return $this->zigbeeRequiresExternalHardware;
    }

    public function getZigbeeUnsecureRejoin(): bool
    {
        return $this->zigbeeUnsecureRejoin;
    }

    public function getZwaveAvailability(): ?string
    {
        return $this->zwaveAvailability;
    }

    public function getZwaveHomeID(): ?string
    {
        return $this->zwaveHomeID;
    }

    public function getZwaveNodeID(): ?string
    {
        return $this->zwaveNodeID;
    }

    public function getZwaveRadioDetected(): ?bool
    {
        return $this->zwaveRadioDetected;
    }

    public function getZwaveRadioEnabled(): ?bool
    {
        return $this->zwaveRadioEnabled;
    }

    public function getZwaveRadioFunctional(): ?bool
    {
        return $this->zwaveRadioFunctional;
    }

    public function getZwaveRegion(): ?string
    {
        return $this->zwaveRegion;
    }

    public function getZwaveS2(): bool
    {
        return $this->zwaveS2;
    }

    public function getZwaveStaticDsk(): ?string
    {
        return $this->zwaveStaticDsk;
    }

    public function getZwaveSucID(): ?string
    {
        return $this->zwaveSucID;
    }

    public function getZwaveVersion(): ?string
    {
        return $this->zwaveVersion;
    }

    public function setChildDeviceAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->childDeviceAvailability = $value;

        return $this;
    }

    public function setEdgeDriversAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->edgeDriversAvailability = $value;

        return $this;
    }

    public function setEdgeDriverSupportedEndpointApps(?EdgeDriverSupportedEndpointAppsInterface $value): HubDeviceDetailsHubDataInterface
    {
        $this->edgeDriverSupportedEndpointApps = $value;

        return $this;
    }

    public function setEnrollmentChannel(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->enrollmentChannel = $value;

        return $this;
    }

    public function setFailoverAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->failoverAvailability = $value;

        return $this;
    }

    public function setHardwareId(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->hardwareId = $value;

        return $this;
    }

    public function setHedgeTlsCertificate(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->hedgeTlsCertificate = $value;

        return $this;
    }

    public function setHub2hubSupportMatrix(?HubDeviceDetailsHubDataHub2hubSupportMatrixInterface $value): HubDeviceDetailsHubDataInterface
    {
        $this->hub2hubSupportMatrix = $value;

        return $this;
    }

    public function setHubLocalApiAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->hubLocalApiAvailability = $value;

        return $this;
    }

    public function setHubReplaceAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->hubReplaceAvailability = $value;

        return $this;
    }

    public function setLanAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->lanAvailability = $value;

        return $this;
    }

    public function setLocalIP(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->localIP = $value;

        return $this;
    }

    public function setLocalVirtualDeviceAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->localVirtualDeviceAvailability = $value;

        return $this;
    }

    public function setMacAddress(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->macAddress = $value;

        return $this;
    }

    public function setMatterAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->matterAvailability = $value;

        return $this;
    }

    public function setMatterDeviceDiagnosticsAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->matterDeviceDiagnosticsAvailability = $value;

        return $this;
    }

    public function setMatterRendezvousHedgeSupported(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->matterRendezvousHedgeSupported = $value;

        return $this;
    }

    public function setMatterSoftwareComponentVersion(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->matterSoftwareComponentVersion = $value;

        return $this;
    }

    public function setOtaEnable(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->otaEnable = $value;

        return $this;
    }

    public function setPrimaryHubDeviceId(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->primaryHubDeviceId = $value;

        return $this;
    }

    public function setPrimarySupportAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->primarySupportAvailability = $value;

        return $this;
    }

    public function setRepeaterReachability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->repeaterReachability = $value;

        return $this;
    }

    public function setSecondarySupportAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->secondarySupportAvailability = $value;

        return $this;
    }

    public function setSerialNumber(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->serialNumber = $value;

        return $this;
    }

    public function setThreadAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->threadAvailability = $value;

        return $this;
    }

    public function setThreadRequiresExternalHardware(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->threadRequiresExternalHardware = $value;

        return $this;
    }

    public function setWifiSsid(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->wifiSsid = $value;

        return $this;
    }

    public function setZigbeeAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeAvailability = $value;

        return $this;
    }

    public function setZigbeeChannel(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeChannel = $value;

        return $this;
    }

    public function setZigbeeDeviceDiagnosticsAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeDeviceDiagnosticsAvailability = $value;

        return $this;
    }

    public function setZigbeeEui(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeEui = $value;

        return $this;
    }

    public function setZigbeeFirmware(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeFirmware = $value;

        return $this;
    }

    public function setZigbeeManualFirmwareUpdateSupported(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeManualFirmwareUpdateSupported = $value;

        return $this;
    }

    public function setZigbeeNodeID(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeNodeID = $value;

        return $this;
    }

    public function setZigbeeOta(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeOta = $value;

        return $this;
    }

    public function setZigbeePanId(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeePanId = $value;

        return $this;
    }

    public function setZigbeeRadioDetected(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeRadioDetected = $value;

        return $this;
    }

    public function setZigbeeRadioEnabled(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeRadioEnabled = $value;

        return $this;
    }

    public function setZigbeeRadioFunctional(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeRadioFunctional = $value;

        return $this;
    }

    public function setZigbeeRequiresExternalHardware(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zigbeeRequiresExternalHardware = $value;

        return $this;
    }

    public function setZwaveAvailability(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveAvailability = $value;

        return $this;
    }

    public function setZwaveHomeID(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveHomeID = $value;

        return $this;
    }

    public function setZwaveNodeID(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveNodeID = $value;

        return $this;
    }

    public function setZwaveRadioDetected(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveRadioDetected = $value;

        return $this;
    }

    public function setZwaveRadioEnabled(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveRadioEnabled = $value;

        return $this;
    }

    public function setZwaveRadioFunctional(?bool $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveRadioFunctional = $value;

        return $this;
    }

    public function setZwaveRegion(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveRegion = $value;

        return $this;
    }

    public function setZwaveStaticDsk(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveStaticDsk = $value;

        return $this;
    }

    public function setZwaveSucID(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveSucID = $value;

        return $this;
    }

    public function setZwaveVersion(?string $value): HubDeviceDetailsHubDataInterface
    {
        $this->zwaveVersion = $value;

        return $this;
    }
}
