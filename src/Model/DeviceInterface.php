<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceInterface
{
    /**
     * @return array<int, string>
     */
    public function getAllowed(): array;

    public function getApp(): ?AppDeviceDetailsInterface;

    /**
     * @return mixed[]
     */
    public function getBle(): array;

    public function getBleD2D(): ?BleD2DDeviceDetailsInterface;

    public function getBrandId(): ?string;

    /**
     * @return array<int, DeviceInterface>
     */
    public function getChildDevices(): array;

    /**
     * @return array<int, DeviceComponentInterface>
     */
    public function getComponents(): array;

    public function getCreateTime(): ?string;

    public function getDeviceId(): string;

    public function getDeviceManufacturerCode(): ?string;

    public function getDeviceNetworkType(): ?string;

    public function getDeviceTypeId(): ?string;

    public function getDeviceTypeName(): ?string;

    public function getDth(): ?DthDeviceDetailsInterface;

    public function getEdgeChild(): ?EdgeChildDeviceDetailsInterface;

    public function getExecutionContext(): ?string;

    public function getGroup(): ?GroupDeviceDetailsInterface;

    public function getHealthState(): ?IdLessHealthStateInterface;

    public function getHub(): ?HubDeviceDetailsInterface;

    public function getIndoorMap(): ?IndoorMapInterface;

    public function getIr(): ?IrDeviceDetailsInterface;

    public function getIrOcf(): ?IrDeviceDetailsInterface;

    public function getLabel(): ?string;

    public function getLan(): ?LanDeviceDetailsInterface;

    public function getLocationId(): ?string;

    public function getManufacturerName(): ?string;

    public function getMatter(): ?MatterDeviceDetailsInterface;

    public function getMqtt(): ?MqttDeviceDetailsInterface;

    public function getName(): ?string;

    public function getOcf(): ?OcfDeviceDetailsInterface;

    public function getOwnerId(): ?string;

    public function getParentDeviceId(): ?string;

    public function getPresentationId(): ?string;

    public function getProductId(): ?string;

    public function getProfile(): ?DeviceProfileReferenceInterface;

    /**
     * @return array<int, DeviceRelationshipInterface>
     */
    public function getRelationships(): array;

    public function getRestrictionTier(): ?int;

    public function getRoomId(): ?string;

    public function getType(): ?string;

    public function getViper(): ?ViperDeviceDetailsInterface;

    public function getVirtual(): ?VirtualDeviceDetailsInterface;

    public function getZigbee(): ?ZigbeeDeviceDetailsInterface;

    public function getZwave(): ?ZwaveDeviceDetailsInterface;

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): self;

    public function setApp(?AppDeviceDetailsInterface $value): self;

    /**
     * @param mixed[] $value
     */
    public function setBle(array $value): self;

    public function setBleD2D(?BleD2DDeviceDetailsInterface $value): self;

    public function setBrandId(?string $value): self;

    /**
     * @param array<int, DeviceInterface> $value
     */
    public function setChildDevices(array $value): self;

    /**
     * @param array<int, DeviceComponentInterface> $value
     */
    public function setComponents(array $value): self;

    public function setCreateTime(?string $value): self;

    public function setDeviceId(string $value): self;

    public function setDeviceManufacturerCode(?string $value): self;

    public function setDeviceNetworkType(?string $value): self;

    public function setDeviceTypeId(?string $value): self;

    public function setDeviceTypeName(?string $value): self;

    public function setDth(?DthDeviceDetailsInterface $value): self;

    public function setEdgeChild(?EdgeChildDeviceDetailsInterface $value): self;

    public function setExecutionContext(?string $value): self;

    public function setGroup(?GroupDeviceDetailsInterface $value): self;

    public function setHealthState(?IdLessHealthStateInterface $value): self;

    public function setHub(?HubDeviceDetailsInterface $value): self;

    public function setIndoorMap(?IndoorMapInterface $value): self;

    public function setIr(?IrDeviceDetailsInterface $value): self;

    public function setIrOcf(?IrDeviceDetailsInterface $value): self;

    public function setLabel(?string $value): self;

    public function setLan(?LanDeviceDetailsInterface $value): self;

    public function setLocationId(?string $value): self;

    public function setManufacturerName(?string $value): self;

    public function setMatter(?MatterDeviceDetailsInterface $value): self;

    public function setMqtt(?MqttDeviceDetailsInterface $value): self;

    public function setName(?string $value): self;

    public function setOcf(?OcfDeviceDetailsInterface $value): self;

    public function setOwnerId(?string $value): self;

    public function setParentDeviceId(?string $value): self;

    public function setPresentationId(?string $value): self;

    public function setProductId(?string $value): self;

    public function setProfile(?DeviceProfileReferenceInterface $value): self;

    /**
     * @param array<int, DeviceRelationshipInterface> $value
     */
    public function setRelationships(array $value): self;

    public function setRestrictionTier(?int $value): self;

    public function setRoomId(?string $value): self;

    public function setType(?string $value): self;

    public function setViper(?ViperDeviceDetailsInterface $value): self;

    public function setVirtual(?VirtualDeviceDetailsInterface $value): self;

    public function setZigbee(?ZigbeeDeviceDetailsInterface $value): self;

    public function setZwave(?ZwaveDeviceDetailsInterface $value): self;
}
