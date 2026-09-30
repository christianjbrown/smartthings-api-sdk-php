<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItem;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DeviceConfigurationDpInfoItemTransformer implements DeviceConfigurationDpInfoItemTransformerInterface
{
    private DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface $deviceConfigurationDpInfoItemArgumentsItemTransformer;

    public function __construct(DeviceConfigurationDpInfoItemArgumentsItemTransformerInterface $deviceConfigurationDpInfoItemArgumentsItemTransformer)
    {
        $this->deviceConfigurationDpInfoItemArgumentsItemTransformer = $deviceConfigurationDpInfoItemArgumentsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DeviceConfigurationDpInfoItemInterface
    {
        $model = new DeviceConfigurationDpInfoItem(self::requireOs($data), self::requireDpUri($data));

        self::applyServerDpUri($model, $data);
        self::applyOperatingMode($model, $data);
        $this->applyArguments($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyArguments(DeviceConfigurationDpInfoItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ARGUMENTS])) {
            return;
        }
        if (!is_array($data[self::KEY_ARGUMENTS])) {
            return;
        }
        $model->setArguments($this->transformListDeviceConfigurationDpInfoItemArgumentsItem($data[self::KEY_ARGUMENTS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperatingMode(DeviceConfigurationDpInfoItem $model, array $data): void
    {
        if (empty($data[self::KEY_OPERATING_MODE])) {
            return;
        }
        if (!is_string($data[self::KEY_OPERATING_MODE])) {
            return;
        }
        $model->setOperatingMode($data[self::KEY_OPERATING_MODE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyServerDpUri(DeviceConfigurationDpInfoItem $model, array $data): void
    {
        if (empty($data[self::KEY_SERVER_DP_URI])) {
            return;
        }
        if (!is_string($data[self::KEY_SERVER_DP_URI])) {
            return;
        }
        $model->setServerDpUri($data[self::KEY_SERVER_DP_URI]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDpUri(array $data): ?string
    {
        if (empty($data[self::KEY_DP_URI])) {
            return null;
        }
        if (!is_string($data[self::KEY_DP_URI])) {
            return null;
        }

        return $data[self::KEY_DP_URI];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireOs(array $data): ?string
    {
        if (empty($data[self::KEY_OS])) {
            return null;
        }
        if (!is_string($data[self::KEY_OS])) {
            return null;
        }

        return $data[self::KEY_OS];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface>
     */
    private function transformListDeviceConfigurationDpInfoItemArgumentsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): DeviceConfigurationDpInfoItemArgumentsItemInterface => $this->deviceConfigurationDpInfoItemArgumentsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
