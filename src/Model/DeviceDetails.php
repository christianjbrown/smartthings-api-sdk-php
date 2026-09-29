<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceDetails implements DeviceDetailsInterface
{
    private ?AppDeviceDetailsInterface $app = null;
    private ?BleD2DDeviceDetailsInterface $bleD2D = null;
    private ?DthDeviceDetailsInterface $dth = null;
    private ?EdgeChildDeviceDetailsInterface $edgeChild = null;
    private ?GroupDeviceDetailsInterface $group = null;
    private ?IdLessHealthStateInterface $healthState = null;
    private ?HubDeviceDetailsInterface $hub = null;
    private ?IndoorMapInterface $indoorMap = null;
    private ?IrDeviceDetailsInterface $ir = null;
    private ?IrDeviceDetailsInterface $irOcf = null;
    private ?LanDeviceDetailsInterface $lan = null;
    private ?MatterDeviceDetailsInterface $matter = null;
    private ?MqttDeviceDetailsInterface $mqtt = null;
    private ?OcfDeviceDetailsInterface $ocf = null;
    private ?DeviceProfileReferenceInterface $profile = null;

    /**
     * @var null|array<int, DeviceRelationshipInterface>
     */
    private ?array $relationships = null;
    private ?ViperDeviceDetailsInterface $viper = null;
    private ?VirtualDeviceDetailsInterface $virtual = null;
    private ?ZigbeeDeviceDetailsInterface $zigbee = null;
    private ?ZwaveDeviceDetailsInterface $zwave = null;

    public function getApp(): ?AppDeviceDetailsInterface
    {
        return $this->app;
    }

    public function getBleD2D(): ?BleD2DDeviceDetailsInterface
    {
        return $this->bleD2D;
    }

    public function getDth(): ?DthDeviceDetailsInterface
    {
        return $this->dth;
    }

    public function getEdgeChild(): ?EdgeChildDeviceDetailsInterface
    {
        return $this->edgeChild;
    }

    public function getGroup(): ?GroupDeviceDetailsInterface
    {
        return $this->group;
    }

    public function getHealthState(): ?IdLessHealthStateInterface
    {
        return $this->healthState;
    }

    public function getHub(): ?HubDeviceDetailsInterface
    {
        return $this->hub;
    }

    public function getIndoorMap(): ?IndoorMapInterface
    {
        return $this->indoorMap;
    }

    public function getIr(): ?IrDeviceDetailsInterface
    {
        return $this->ir;
    }

    public function getIrOcf(): ?IrDeviceDetailsInterface
    {
        return $this->irOcf;
    }

    public function getLan(): ?LanDeviceDetailsInterface
    {
        return $this->lan;
    }

    public function getMatter(): ?MatterDeviceDetailsInterface
    {
        return $this->matter;
    }

    public function getMqtt(): ?MqttDeviceDetailsInterface
    {
        return $this->mqtt;
    }

    public function getOcf(): ?OcfDeviceDetailsInterface
    {
        return $this->ocf;
    }

    public function getProfile(): ?DeviceProfileReferenceInterface
    {
        return $this->profile;
    }

    /**
     * @return null|array<int, DeviceRelationshipInterface>
     */
    public function getRelationships(): ?array
    {
        return $this->relationships;
    }

    public function getViper(): ?ViperDeviceDetailsInterface
    {
        return $this->viper;
    }

    public function getVirtual(): ?VirtualDeviceDetailsInterface
    {
        return $this->virtual;
    }

    public function getZigbee(): ?ZigbeeDeviceDetailsInterface
    {
        return $this->zigbee;
    }

    public function getZwave(): ?ZwaveDeviceDetailsInterface
    {
        return $this->zwave;
    }

    public function setApp(?AppDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->app = $value;

        return $this;
    }

    public function setBleD2D(?BleD2DDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->bleD2D = $value;

        return $this;
    }

    public function setDth(?DthDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->dth = $value;

        return $this;
    }

    public function setEdgeChild(?EdgeChildDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->edgeChild = $value;

        return $this;
    }

    public function setGroup(?GroupDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setHealthState(?IdLessHealthStateInterface $value): DeviceDetailsInterface
    {
        $this->healthState = $value;

        return $this;
    }

    public function setHub(?HubDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->hub = $value;

        return $this;
    }

    public function setIndoorMap(?IndoorMapInterface $value): DeviceDetailsInterface
    {
        $this->indoorMap = $value;

        return $this;
    }

    public function setIr(?IrDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->ir = $value;

        return $this;
    }

    public function setIrOcf(?IrDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->irOcf = $value;

        return $this;
    }

    public function setLan(?LanDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->lan = $value;

        return $this;
    }

    public function setMatter(?MatterDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->matter = $value;

        return $this;
    }

    public function setMqtt(?MqttDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->mqtt = $value;

        return $this;
    }

    public function setOcf(?OcfDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->ocf = $value;

        return $this;
    }

    public function setProfile(?DeviceProfileReferenceInterface $value): DeviceDetailsInterface
    {
        $this->profile = $value;

        return $this;
    }

    /**
     * @param null|array<int, DeviceRelationshipInterface> $value
     */
    public function setRelationships(?array $value): DeviceDetailsInterface
    {
        $this->relationships = $value;

        return $this;
    }

    public function setViper(?ViperDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->viper = $value;

        return $this;
    }

    public function setVirtual(?VirtualDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->virtual = $value;

        return $this;
    }

    public function setZigbee(?ZigbeeDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->zigbee = $value;

        return $this;
    }

    public function setZwave(?ZwaveDeviceDetailsInterface $value): DeviceDetailsInterface
    {
        $this->zwave = $value;

        return $this;
    }
}
