<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DeviceConfigurationDpInfosItemTransformer implements DeviceConfigurationDpInfosItemTransformerInterface
{
    private DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer;

    public function __construct(DeviceConfigurationDpInfoItemTransformerInterface $deviceConfigurationDpInfoItemTransformer)
    {
        $this->deviceConfigurationDpInfoItemTransformer = $deviceConfigurationDpInfoItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDpInfosItemInterface
    {
        $model = new DeviceConfigurationDpInfosItem($this->requireDpInfo($data));

        self::applyStPluginApiVersion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyStPluginApiVersion(DeviceConfigurationDpInfosItem $model, array $data): void
    {
        if (empty($data[self::KEY_ST_PLUGIN_API_VERSION])) {
            return;
        }
        if (!is_string($data[self::KEY_ST_PLUGIN_API_VERSION])) {
            return;
        }
        $model->setStPluginApiVersion($data[self::KEY_ST_PLUGIN_API_VERSION]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationDpInfoItemInterface>
     */
    private function requireDpInfo(array $data): array
    {
        if (!isset($data[self::KEY_DP_INFO])) {
            return [];
        }
        if (!is_array($data[self::KEY_DP_INFO])) {
            return [];
        }

        return $this->transformListDeviceConfigurationDpInfoItem($data[self::KEY_DP_INFO]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationDpInfoItemInterface>
     */
    private function transformListDeviceConfigurationDpInfoItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationDpInfoItemInterface => $this->deviceConfigurationDpInfoItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
