<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface HubDeviceDetailsHubDataInterface
{
    public function getChildDeviceAvailability(): ?string;

    public function getEdgeDriversAvailability(): ?string;

    public function getEdgeDriverSupportedEndpointApps(): ?EdgeDriverSupportedEndpointAppsInterface;

    public function getEnrollmentChannel(): ?string;

    public function getFailoverAvailability(): ?string;

    public function getHardwareId(): ?string;

    public function getHardwareType(): string;

    public function getHedgeTlsCertificate(): ?string;

    public function getHub2hubSupportMatrix(): ?HubDeviceDetailsHubDataHub2hubSupportMatrixInterface;

    public function getHubLocalApiAvailability(): ?string;

    public function getHubReplaceAvailability(): ?string;

    public function getLanAvailability(): ?string;

    public function getLocalIP(): ?string;

    public function getLocalVirtualDeviceAvailability(): ?string;

    public function getMacAddress(): ?string;

    public function getMatterAvailability(): ?string;

    public function getMatterDeviceDiagnosticsAvailability(): ?string;

    public function getMatterRendezvousHedgeSupported(): ?bool;

    public function getMatterSoftwareComponentVersion(): ?string;

    public function getOtaEnable(): ?string;

    public function getPrimaryHubDeviceId(): ?string;

    public function getPrimarySupportAvailability(): ?string;

    public function getRepeaterReachability(): ?string;

    public function getSecondarySupportAvailability(): ?string;

    public function getSerialNumber(): ?string;

    public function getThreadAvailability(): ?string;

    public function getThreadRequiresExternalHardware(): ?bool;

    public function getWifiSsid(): ?string;

    public function getZigbee3(): bool;

    public function getZigbeeAvailability(): ?string;

    public function getZigbeeChannel(): ?string;

    public function getZigbeeDeviceDiagnosticsAvailability(): ?string;

    public function getZigbeeEui(): ?string;

    public function getZigbeeFirmware(): ?string;

    public function getZigbeeManualFirmwareUpdateSupported(): ?bool;

    public function getZigbeeNodeID(): ?string;

    public function getZigbeeOta(): ?string;

    public function getZigbeePanId(): ?string;

    public function getZigbeeRadioDetected(): ?bool;

    public function getZigbeeRadioEnabled(): ?bool;

    public function getZigbeeRadioFunctional(): ?bool;

    public function getZigbeeRequiresExternalHardware(): ?bool;

    public function getZigbeeUnsecureRejoin(): bool;

    public function getZwaveAvailability(): ?string;

    public function getZwaveHomeID(): ?string;

    public function getZwaveNodeID(): ?string;

    public function getZwaveRadioDetected(): ?bool;

    public function getZwaveRadioEnabled(): ?bool;

    public function getZwaveRadioFunctional(): ?bool;

    public function getZwaveRegion(): ?string;

    public function getZwaveS2(): bool;

    public function getZwaveStaticDsk(): ?string;

    public function getZwaveSucID(): ?string;

    public function getZwaveVersion(): ?string;

    public function setChildDeviceAvailability(?string $value): self;

    public function setEdgeDriversAvailability(?string $value): self;

    public function setEdgeDriverSupportedEndpointApps(?EdgeDriverSupportedEndpointAppsInterface $value): self;

    public function setEnrollmentChannel(?string $value): self;

    public function setFailoverAvailability(?string $value): self;

    public function setHardwareId(?string $value): self;

    public function setHedgeTlsCertificate(?string $value): self;

    public function setHub2hubSupportMatrix(?HubDeviceDetailsHubDataHub2hubSupportMatrixInterface $value): self;

    public function setHubLocalApiAvailability(?string $value): self;

    public function setHubReplaceAvailability(?string $value): self;

    public function setLanAvailability(?string $value): self;

    public function setLocalIP(?string $value): self;

    public function setLocalVirtualDeviceAvailability(?string $value): self;

    public function setMacAddress(?string $value): self;

    public function setMatterAvailability(?string $value): self;

    public function setMatterDeviceDiagnosticsAvailability(?string $value): self;

    public function setMatterRendezvousHedgeSupported(?bool $value): self;

    public function setMatterSoftwareComponentVersion(?string $value): self;

    public function setOtaEnable(?string $value): self;

    public function setPrimaryHubDeviceId(?string $value): self;

    public function setPrimarySupportAvailability(?string $value): self;

    public function setRepeaterReachability(?string $value): self;

    public function setSecondarySupportAvailability(?string $value): self;

    public function setSerialNumber(?string $value): self;

    public function setThreadAvailability(?string $value): self;

    public function setThreadRequiresExternalHardware(?bool $value): self;

    public function setWifiSsid(?string $value): self;

    public function setZigbeeAvailability(?string $value): self;

    public function setZigbeeChannel(?string $value): self;

    public function setZigbeeDeviceDiagnosticsAvailability(?string $value): self;

    public function setZigbeeEui(?string $value): self;

    public function setZigbeeFirmware(?string $value): self;

    public function setZigbeeManualFirmwareUpdateSupported(?bool $value): self;

    public function setZigbeeNodeID(?string $value): self;

    public function setZigbeeOta(?string $value): self;

    public function setZigbeePanId(?string $value): self;

    public function setZigbeeRadioDetected(?bool $value): self;

    public function setZigbeeRadioEnabled(?bool $value): self;

    public function setZigbeeRadioFunctional(?bool $value): self;

    public function setZigbeeRequiresExternalHardware(?bool $value): self;

    public function setZwaveAvailability(?string $value): self;

    public function setZwaveHomeID(?string $value): self;

    public function setZwaveNodeID(?string $value): self;

    public function setZwaveRadioDetected(?bool $value): self;

    public function setZwaveRadioEnabled(?bool $value): self;

    public function setZwaveRadioFunctional(?bool $value): self;

    public function setZwaveRegion(?string $value): self;

    public function setZwaveStaticDsk(?string $value): self;

    public function setZwaveSucID(?string $value): self;

    public function setZwaveVersion(?string $value): self;
}
