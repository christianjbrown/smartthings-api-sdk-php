<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DeviceDetailsInterface
{
    public function getApp(): ?AppDeviceDetailsInterface;

    public function getBleD2D(): ?BleD2DDeviceDetailsInterface;

    public function getDth(): ?DthDeviceDetailsInterface;

    public function getEdgeChild(): ?EdgeChildDeviceDetailsInterface;

    public function getGroup(): ?GroupDeviceDetailsInterface;

    public function getHealthState(): ?IdLessHealthStateInterface;

    public function getHub(): ?HubDeviceDetailsInterface;

    public function getIndoorMap(): ?IndoorMapInterface;

    public function getIr(): ?IrDeviceDetailsInterface;

    public function getIrOcf(): ?IrDeviceDetailsInterface;

    public function getLan(): ?LanDeviceDetailsInterface;

    public function getMatter(): ?MatterDeviceDetailsInterface;

    public function getMqtt(): ?MqttDeviceDetailsInterface;

    public function getOcf(): ?OcfDeviceDetailsInterface;

    public function getProfile(): ?DeviceProfileReferenceInterface;

    /**
     * @return null|array<int, DeviceRelationshipInterface>
     */
    public function getRelationships(): ?array;

    public function getViper(): ?ViperDeviceDetailsInterface;

    public function getVirtual(): ?VirtualDeviceDetailsInterface;

    public function getZigbee(): ?ZigbeeDeviceDetailsInterface;

    public function getZwave(): ?ZwaveDeviceDetailsInterface;

    public function setApp(?AppDeviceDetailsInterface $value): self;

    public function setBleD2D(?BleD2DDeviceDetailsInterface $value): self;

    public function setDth(?DthDeviceDetailsInterface $value): self;

    public function setEdgeChild(?EdgeChildDeviceDetailsInterface $value): self;

    public function setGroup(?GroupDeviceDetailsInterface $value): self;

    public function setHealthState(?IdLessHealthStateInterface $value): self;

    public function setHub(?HubDeviceDetailsInterface $value): self;

    public function setIndoorMap(?IndoorMapInterface $value): self;

    public function setIr(?IrDeviceDetailsInterface $value): self;

    public function setIrOcf(?IrDeviceDetailsInterface $value): self;

    public function setLan(?LanDeviceDetailsInterface $value): self;

    public function setMatter(?MatterDeviceDetailsInterface $value): self;

    public function setMqtt(?MqttDeviceDetailsInterface $value): self;

    public function setOcf(?OcfDeviceDetailsInterface $value): self;

    public function setProfile(?DeviceProfileReferenceInterface $value): self;

    /**
     * @param null|array<int, DeviceRelationshipInterface> $value
     */
    public function setRelationships(?array $value): self;

    public function setViper(?ViperDeviceDetailsInterface $value): self;

    public function setVirtual(?VirtualDeviceDetailsInterface $value): self;

    public function setZigbee(?ZigbeeDeviceDetailsInterface $value): self;

    public function setZwave(?ZwaveDeviceDetailsInterface $value): self;
}
