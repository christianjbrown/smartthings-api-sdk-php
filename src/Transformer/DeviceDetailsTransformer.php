<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceDetails;
use ChristianBrown\SmartThings\Model\DeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\DeviceRelationshipInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

final class DeviceDetailsTransformer implements DeviceDetailsTransformerInterface
{
    private AppDeviceDetailsTransformerInterface $appDeviceDetailsTransformer;
    private BleD2DDeviceDetailsTransformerInterface $bleD2DDeviceDetailsTransformer;
    private DeviceProfileReferenceTransformerInterface $deviceProfileReferenceTransformer;
    private DeviceRelationshipTransformerInterface $deviceRelationshipTransformer;
    private DthDeviceDetailsTransformerInterface $dthDeviceDetailsTransformer;
    private EdgeChildDeviceDetailsTransformerInterface $edgeChildDeviceDetailsTransformer;
    private GroupDeviceDetailsTransformerInterface $groupDeviceDetailsTransformer;
    private HubDeviceDetailsTransformerInterface $hubDeviceDetailsTransformer;
    private IdLessHealthStateTransformerInterface $idLessHealthStateTransformer;
    private IndoorMapTransformerInterface $indoorMapTransformer;
    private IrDeviceDetailsTransformerInterface $irDeviceDetailsTransformer;
    private LanDeviceDetailsTransformerInterface $lanDeviceDetailsTransformer;
    private MatterDeviceDetailsTransformerInterface $matterDeviceDetailsTransformer;
    private MqttDeviceDetailsTransformerInterface $mqttDeviceDetailsTransformer;
    private OcfDeviceDetailsTransformerInterface $ocfDeviceDetailsTransformer;
    private ViperDeviceDetailsTransformerInterface $viperDeviceDetailsTransformer;
    private VirtualDeviceDetailsTransformerInterface $virtualDeviceDetailsTransformer;
    private ZigbeeDeviceDetailsTransformerInterface $zigbeeDeviceDetailsTransformer;
    private ZwaveDeviceDetailsTransformerInterface $zwaveDeviceDetailsTransformer;

    public function __construct(IdLessHealthStateTransformerInterface $idLessHealthStateTransformer, DeviceProfileReferenceTransformerInterface $deviceProfileReferenceTransformer, AppDeviceDetailsTransformerInterface $appDeviceDetailsTransformer, BleD2DDeviceDetailsTransformerInterface $bleD2DDeviceDetailsTransformer, DthDeviceDetailsTransformerInterface $dthDeviceDetailsTransformer, LanDeviceDetailsTransformerInterface $lanDeviceDetailsTransformer, ZigbeeDeviceDetailsTransformerInterface $zigbeeDeviceDetailsTransformer, ZwaveDeviceDetailsTransformerInterface $zwaveDeviceDetailsTransformer, MatterDeviceDetailsTransformerInterface $matterDeviceDetailsTransformer, HubDeviceDetailsTransformerInterface $hubDeviceDetailsTransformer, EdgeChildDeviceDetailsTransformerInterface $edgeChildDeviceDetailsTransformer, IrDeviceDetailsTransformerInterface $irDeviceDetailsTransformer, OcfDeviceDetailsTransformerInterface $ocfDeviceDetailsTransformer, ViperDeviceDetailsTransformerInterface $viperDeviceDetailsTransformer, GroupDeviceDetailsTransformerInterface $groupDeviceDetailsTransformer, VirtualDeviceDetailsTransformerInterface $virtualDeviceDetailsTransformer, MqttDeviceDetailsTransformerInterface $mqttDeviceDetailsTransformer, IndoorMapTransformerInterface $indoorMapTransformer, DeviceRelationshipTransformerInterface $deviceRelationshipTransformer)
    {
        $this->idLessHealthStateTransformer = $idLessHealthStateTransformer;
        $this->deviceProfileReferenceTransformer = $deviceProfileReferenceTransformer;
        $this->appDeviceDetailsTransformer = $appDeviceDetailsTransformer;
        $this->bleD2DDeviceDetailsTransformer = $bleD2DDeviceDetailsTransformer;
        $this->dthDeviceDetailsTransformer = $dthDeviceDetailsTransformer;
        $this->lanDeviceDetailsTransformer = $lanDeviceDetailsTransformer;
        $this->zigbeeDeviceDetailsTransformer = $zigbeeDeviceDetailsTransformer;
        $this->zwaveDeviceDetailsTransformer = $zwaveDeviceDetailsTransformer;
        $this->matterDeviceDetailsTransformer = $matterDeviceDetailsTransformer;
        $this->hubDeviceDetailsTransformer = $hubDeviceDetailsTransformer;
        $this->edgeChildDeviceDetailsTransformer = $edgeChildDeviceDetailsTransformer;
        $this->irDeviceDetailsTransformer = $irDeviceDetailsTransformer;
        $this->ocfDeviceDetailsTransformer = $ocfDeviceDetailsTransformer;
        $this->viperDeviceDetailsTransformer = $viperDeviceDetailsTransformer;
        $this->groupDeviceDetailsTransformer = $groupDeviceDetailsTransformer;
        $this->virtualDeviceDetailsTransformer = $virtualDeviceDetailsTransformer;
        $this->mqttDeviceDetailsTransformer = $mqttDeviceDetailsTransformer;
        $this->indoorMapTransformer = $indoorMapTransformer;
        $this->deviceRelationshipTransformer = $deviceRelationshipTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceDetailsInterface
    {
        $model = new DeviceDetails();

        $this->applyHealthState($model, $data);
        $this->applyProfile($model, $data);
        $this->applyApp($model, $data);
        $this->applyBleD2D($model, $data);
        $this->applyDth($model, $data);
        $this->applyLan($model, $data);
        $this->applyZigbee($model, $data);
        $this->applyZwave($model, $data);
        $this->applyMatter($model, $data);
        $this->applyHub($model, $data);
        $this->applyEdgeChild($model, $data);
        $this->applyIr($model, $data);
        $this->applyIrOcf($model, $data);
        $this->applyOcf($model, $data);
        $this->applyViper($model, $data);
        $this->applyGroup($model, $data);
        $this->applyVirtual($model, $data);
        $this->applyMqtt($model, $data);
        $this->applyIndoorMap($model, $data);
        $this->applyRelationships($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyApp(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_APP])) {
            return;
        }
        if (!is_array($data[self::KEY_APP])) {
            return;
        }
        $model->setApp($this->appDeviceDetailsTransformer->transform($data[self::KEY_APP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBleD2D(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_BLE_D2_D])) {
            return;
        }
        if (!is_array($data[self::KEY_BLE_D2_D])) {
            return;
        }
        $model->setBleD2D($this->bleD2DDeviceDetailsTransformer->transform($data[self::KEY_BLE_D2_D]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDth(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_DTH])) {
            return;
        }
        if (!is_array($data[self::KEY_DTH])) {
            return;
        }
        $model->setDth($this->dthDeviceDetailsTransformer->transform($data[self::KEY_DTH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEdgeChild(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_EDGE_CHILD])) {
            return;
        }
        if (!is_array($data[self::KEY_EDGE_CHILD])) {
            return;
        }
        $model->setEdgeChild($this->edgeChildDeviceDetailsTransformer->transform($data[self::KEY_EDGE_CHILD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyGroup(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_GROUP])) {
            return;
        }
        if (!is_array($data[self::KEY_GROUP])) {
            return;
        }
        $model->setGroup($this->groupDeviceDetailsTransformer->transform($data[self::KEY_GROUP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHealthState(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_HEALTH_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_HEALTH_STATE])) {
            return;
        }
        $model->setHealthState($this->idLessHealthStateTransformer->transform($data[self::KEY_HEALTH_STATE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHub(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_HUB])) {
            return;
        }
        if (!is_array($data[self::KEY_HUB])) {
            return;
        }
        $model->setHub($this->hubDeviceDetailsTransformer->transform($data[self::KEY_HUB]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIndoorMap(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_INDOOR_MAP])) {
            return;
        }
        if (!is_array($data[self::KEY_INDOOR_MAP])) {
            return;
        }
        $model->setIndoorMap($this->indoorMapTransformer->transform($data[self::KEY_INDOOR_MAP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIr(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_IR])) {
            return;
        }
        if (!is_array($data[self::KEY_IR])) {
            return;
        }
        $model->setIr($this->irDeviceDetailsTransformer->transform($data[self::KEY_IR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyIrOcf(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_IR_OCF])) {
            return;
        }
        if (!is_array($data[self::KEY_IR_OCF])) {
            return;
        }
        $model->setIrOcf($this->irDeviceDetailsTransformer->transform($data[self::KEY_IR_OCF]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLan(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_LAN])) {
            return;
        }
        if (!is_array($data[self::KEY_LAN])) {
            return;
        }
        $model->setLan($this->lanDeviceDetailsTransformer->transform($data[self::KEY_LAN]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMatter(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_MATTER])) {
            return;
        }
        if (!is_array($data[self::KEY_MATTER])) {
            return;
        }
        $model->setMatter($this->matterDeviceDetailsTransformer->transform($data[self::KEY_MATTER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMqtt(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_MQTT])) {
            return;
        }
        if (!is_array($data[self::KEY_MQTT])) {
            return;
        }
        $model->setMqtt($this->mqttDeviceDetailsTransformer->transform($data[self::KEY_MQTT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyOcf(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_OCF])) {
            return;
        }
        if (!is_array($data[self::KEY_OCF])) {
            return;
        }
        $model->setOcf($this->ocfDeviceDetailsTransformer->transform($data[self::KEY_OCF]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProfile(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_PROFILE])) {
            return;
        }
        if (!is_array($data[self::KEY_PROFILE])) {
            return;
        }
        $model->setProfile($this->deviceProfileReferenceTransformer->transform($data[self::KEY_PROFILE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyRelationships(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_RELATIONSHIPS])) {
            return;
        }
        if (!is_array($data[self::KEY_RELATIONSHIPS])) {
            return;
        }
        $model->setRelationships($this->transformListDeviceRelationship($data[self::KEY_RELATIONSHIPS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyViper(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VIPER])) {
            return;
        }
        if (!is_array($data[self::KEY_VIPER])) {
            return;
        }
        $model->setViper($this->viperDeviceDetailsTransformer->transform($data[self::KEY_VIPER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVirtual(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_VIRTUAL])) {
            return;
        }
        if (!is_array($data[self::KEY_VIRTUAL])) {
            return;
        }
        $model->setVirtual($this->virtualDeviceDetailsTransformer->transform($data[self::KEY_VIRTUAL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZigbee(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ZIGBEE])) {
            return;
        }
        if (!is_array($data[self::KEY_ZIGBEE])) {
            return;
        }
        $model->setZigbee($this->zigbeeDeviceDetailsTransformer->transform($data[self::KEY_ZIGBEE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyZwave(DeviceDetails $model, array $data): void
    {
        if (!isset($data[self::KEY_ZWAVE])) {
            return;
        }
        if (!is_array($data[self::KEY_ZWAVE])) {
            return;
        }
        $model->setZwave($this->zwaveDeviceDetailsTransformer->transform($data[self::KEY_ZWAVE]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceRelationshipInterface>
     */
    private function transformListDeviceRelationship(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceRelationshipInterface => $this->deviceRelationshipTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
