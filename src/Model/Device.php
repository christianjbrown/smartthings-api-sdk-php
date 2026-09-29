<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Device implements DeviceInterface
{
    /**
     * @var array<int, string>
     */
    private array $allowed = [];
    private ?AppDeviceDetailsInterface $app = null;

    /**
     * @var mixed[]
     */
    private array $ble = [];
    private ?BleD2DDeviceDetailsInterface $bleD2D = null;
    private ?string $brandId = null;

    /**
     * @var array<int, DeviceInterface>
     */
    private array $childDevices = [];

    /**
     * @var array<int, DeviceComponentInterface>
     */
    private array $components = [];
    private ?string $createTime = null;
    private string $deviceId;
    private ?string $deviceManufacturerCode = null;
    private ?string $deviceNetworkType = null;
    private ?string $deviceTypeId = null;
    private ?string $deviceTypeName = null;
    private ?DthDeviceDetailsInterface $dth = null;
    private ?EdgeChildDeviceDetailsInterface $edgeChild = null;
    private ?string $executionContext = null;
    private ?GroupDeviceDetailsInterface $group = null;
    private ?IdLessHealthStateInterface $healthState = null;
    private ?HubDeviceDetailsInterface $hub = null;
    private ?IndoorMapInterface $indoorMap = null;
    private ?IrDeviceDetailsInterface $ir = null;
    private ?IrDeviceDetailsInterface $irOcf = null;
    private ?string $label = null;
    private ?LanDeviceDetailsInterface $lan = null;
    private ?string $locationId = null;
    private ?string $manufacturerName = null;
    private ?MatterDeviceDetailsInterface $matter = null;
    private ?MqttDeviceDetailsInterface $mqtt = null;
    private ?string $name = null;
    private ?OcfDeviceDetailsInterface $ocf = null;
    private ?string $ownerId = null;
    private ?string $parentDeviceId = null;
    private ?string $presentationId = null;
    private ?string $productId = null;
    private ?DeviceProfileReferenceInterface $profile = null;

    /**
     * @var array<int, DeviceRelationshipInterface>
     */
    private array $relationships = [];
    private ?int $restrictionTier = null;
    private ?string $roomId = null;
    private ?string $type = null;
    private ?ViperDeviceDetailsInterface $viper = null;
    private ?VirtualDeviceDetailsInterface $virtual = null;
    private ?ZigbeeDeviceDetailsInterface $zigbee = null;
    private ?ZwaveDeviceDetailsInterface $zwave = null;

    public function __construct(string $deviceId)
    {
        $this->deviceId = $deviceId;
    }

    /**
     * @return array<int, string>
     */
    public function getAllowed(): array
    {
        return $this->allowed;
    }

    public function getApp(): ?AppDeviceDetailsInterface
    {
        return $this->app;
    }

    /**
     * @return mixed[]
     */
    public function getBle(): array
    {
        return $this->ble;
    }

    public function getBleD2D(): ?BleD2DDeviceDetailsInterface
    {
        return $this->bleD2D;
    }

    public function getBrandId(): ?string
    {
        return $this->brandId;
    }

    /**
     * @return array<int, DeviceInterface>
     */
    public function getChildDevices(): array
    {
        return $this->childDevices;
    }

    /**
     * @return array<int, DeviceComponentInterface>
     */
    public function getComponents(): array
    {
        return $this->components;
    }

    public function getCreateTime(): ?string
    {
        return $this->createTime;
    }

    public function getDeviceId(): string
    {
        return $this->deviceId;
    }

    public function getDeviceManufacturerCode(): ?string
    {
        return $this->deviceManufacturerCode;
    }

    public function getDeviceNetworkType(): ?string
    {
        return $this->deviceNetworkType;
    }

    public function getDeviceTypeId(): ?string
    {
        return $this->deviceTypeId;
    }

    public function getDeviceTypeName(): ?string
    {
        return $this->deviceTypeName;
    }

    public function getDth(): ?DthDeviceDetailsInterface
    {
        return $this->dth;
    }

    public function getEdgeChild(): ?EdgeChildDeviceDetailsInterface
    {
        return $this->edgeChild;
    }

    public function getExecutionContext(): ?string
    {
        return $this->executionContext;
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getLan(): ?LanDeviceDetailsInterface
    {
        return $this->lan;
    }

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function getMatter(): ?MatterDeviceDetailsInterface
    {
        return $this->matter;
    }

    public function getMqtt(): ?MqttDeviceDetailsInterface
    {
        return $this->mqtt;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOcf(): ?OcfDeviceDetailsInterface
    {
        return $this->ocf;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function getParentDeviceId(): ?string
    {
        return $this->parentDeviceId;
    }

    public function getPresentationId(): ?string
    {
        return $this->presentationId;
    }

    public function getProductId(): ?string
    {
        return $this->productId;
    }

    public function getProfile(): ?DeviceProfileReferenceInterface
    {
        return $this->profile;
    }

    /**
     * @return array<int, DeviceRelationshipInterface>
     */
    public function getRelationships(): array
    {
        return $this->relationships;
    }

    public function getRestrictionTier(): ?int
    {
        return $this->restrictionTier;
    }

    public function getRoomId(): ?string
    {
        return $this->roomId;
    }

    public function getType(): ?string
    {
        return $this->type;
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

    /**
     * @param array<int, string> $value
     */
    public function setAllowed(array $value): DeviceInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setApp(?AppDeviceDetailsInterface $value): DeviceInterface
    {
        $this->app = $value;

        return $this;
    }

    /**
     * @param mixed[] $value
     */
    public function setBle(array $value): DeviceInterface
    {
        $this->ble = $value;

        return $this;
    }

    public function setBleD2D(?BleD2DDeviceDetailsInterface $value): DeviceInterface
    {
        $this->bleD2D = $value;

        return $this;
    }

    public function setBrandId(?string $value): DeviceInterface
    {
        $this->brandId = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceInterface> $value
     */
    public function setChildDevices(array $value): DeviceInterface
    {
        $this->childDevices = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceComponentInterface> $value
     */
    public function setComponents(array $value): DeviceInterface
    {
        $this->components = $value;

        return $this;
    }

    public function setCreateTime(?string $value): DeviceInterface
    {
        $this->createTime = $value;

        return $this;
    }

    public function setDeviceId(string $value): DeviceInterface
    {
        $this->deviceId = $value;

        return $this;
    }

    public function setDeviceManufacturerCode(?string $value): DeviceInterface
    {
        $this->deviceManufacturerCode = $value;

        return $this;
    }

    public function setDeviceNetworkType(?string $value): DeviceInterface
    {
        $this->deviceNetworkType = $value;

        return $this;
    }

    public function setDeviceTypeId(?string $value): DeviceInterface
    {
        $this->deviceTypeId = $value;

        return $this;
    }

    public function setDeviceTypeName(?string $value): DeviceInterface
    {
        $this->deviceTypeName = $value;

        return $this;
    }

    public function setDth(?DthDeviceDetailsInterface $value): DeviceInterface
    {
        $this->dth = $value;

        return $this;
    }

    public function setEdgeChild(?EdgeChildDeviceDetailsInterface $value): DeviceInterface
    {
        $this->edgeChild = $value;

        return $this;
    }

    public function setExecutionContext(?string $value): DeviceInterface
    {
        $this->executionContext = $value;

        return $this;
    }

    public function setGroup(?GroupDeviceDetailsInterface $value): DeviceInterface
    {
        $this->group = $value;

        return $this;
    }

    public function setHealthState(?IdLessHealthStateInterface $value): DeviceInterface
    {
        $this->healthState = $value;

        return $this;
    }

    public function setHub(?HubDeviceDetailsInterface $value): DeviceInterface
    {
        $this->hub = $value;

        return $this;
    }

    public function setIndoorMap(?IndoorMapInterface $value): DeviceInterface
    {
        $this->indoorMap = $value;

        return $this;
    }

    public function setIr(?IrDeviceDetailsInterface $value): DeviceInterface
    {
        $this->ir = $value;

        return $this;
    }

    public function setIrOcf(?IrDeviceDetailsInterface $value): DeviceInterface
    {
        $this->irOcf = $value;

        return $this;
    }

    public function setLabel(?string $value): DeviceInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setLan(?LanDeviceDetailsInterface $value): DeviceInterface
    {
        $this->lan = $value;

        return $this;
    }

    public function setLocationId(?string $value): DeviceInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setManufacturerName(?string $value): DeviceInterface
    {
        $this->manufacturerName = $value;

        return $this;
    }

    public function setMatter(?MatterDeviceDetailsInterface $value): DeviceInterface
    {
        $this->matter = $value;

        return $this;
    }

    public function setMqtt(?MqttDeviceDetailsInterface $value): DeviceInterface
    {
        $this->mqtt = $value;

        return $this;
    }

    public function setName(?string $value): DeviceInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setOcf(?OcfDeviceDetailsInterface $value): DeviceInterface
    {
        $this->ocf = $value;

        return $this;
    }

    public function setOwnerId(?string $value): DeviceInterface
    {
        $this->ownerId = $value;

        return $this;
    }

    public function setParentDeviceId(?string $value): DeviceInterface
    {
        $this->parentDeviceId = $value;

        return $this;
    }

    public function setPresentationId(?string $value): DeviceInterface
    {
        $this->presentationId = $value;

        return $this;
    }

    public function setProductId(?string $value): DeviceInterface
    {
        $this->productId = $value;

        return $this;
    }

    public function setProfile(?DeviceProfileReferenceInterface $value): DeviceInterface
    {
        $this->profile = $value;

        return $this;
    }

    /**
     * @param array<int, DeviceRelationshipInterface> $value
     */
    public function setRelationships(array $value): DeviceInterface
    {
        $this->relationships = $value;

        return $this;
    }

    public function setRestrictionTier(?int $value): DeviceInterface
    {
        $this->restrictionTier = $value;

        return $this;
    }

    public function setRoomId(?string $value): DeviceInterface
    {
        $this->roomId = $value;

        return $this;
    }

    public function setType(?string $value): DeviceInterface
    {
        $this->type = $value;

        return $this;
    }

    public function setViper(?ViperDeviceDetailsInterface $value): DeviceInterface
    {
        $this->viper = $value;

        return $this;
    }

    public function setVirtual(?VirtualDeviceDetailsInterface $value): DeviceInterface
    {
        $this->virtual = $value;

        return $this;
    }

    public function setZigbee(?ZigbeeDeviceDetailsInterface $value): DeviceInterface
    {
        $this->zigbee = $value;

        return $this;
    }

    public function setZwave(?ZwaveDeviceDetailsInterface $value): DeviceInterface
    {
        $this->zwave = $value;

        return $this;
    }
}
