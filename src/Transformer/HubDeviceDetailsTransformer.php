<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubDeviceDetails;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataInterface;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\HubDriverInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class HubDeviceDetailsTransformer implements HubDeviceDetailsTransformerInterface
{
    private HubDeviceDetailsHubDataTransformerInterface $hubDeviceDetailsHubDataTransformer;
    private HubDriverTransformerInterface $hubDriverTransformer;

    public function __construct(HubDriverTransformerInterface $hubDriverTransformer, HubDeviceDetailsHubDataTransformerInterface $hubDeviceDetailsHubDataTransformer)
    {
        $this->hubDriverTransformer = $hubDriverTransformer;
        $this->hubDeviceDetailsHubDataTransformer = $hubDeviceDetailsHubDataTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsInterface
    {
        $model = new HubDeviceDetails(self::requireHubEui($data), self::requireFirmwareVersion($data), $this->requireHubDrivers($data), $this->requireHubData($data), self::requireDriverId($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDriverId(array $data): ?string
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            return null;
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            return null;
        }

        return $data[self::KEY_DRIVER_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireFirmwareVersion(array $data): ?string
    {
        if (empty($data[self::KEY_FIRMWARE_VERSION])) {
            return null;
        }
        if (!is_string($data[self::KEY_FIRMWARE_VERSION])) {
            return null;
        }

        return $data[self::KEY_FIRMWARE_VERSION];
    }

    /**
     * @param mixed[] $data
     */
    private function requireHubData(array $data): ?HubDeviceDetailsHubDataInterface
    {
        if (!isset($data[self::KEY_HUB_DATA])) {
            return null;
        }
        if (!is_array($data[self::KEY_HUB_DATA])) {
            return null;
        }

        return $this->hubDeviceDetailsHubDataTransformer->transform($data[self::KEY_HUB_DATA]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubDriverInterface>
     */
    private function requireHubDrivers(array $data): array
    {
        if (!isset($data[self::KEY_HUB_DRIVERS])) {
            return [];
        }
        if (!is_array($data[self::KEY_HUB_DRIVERS])) {
            return [];
        }

        return $this->transformListHubDriver($data[self::KEY_HUB_DRIVERS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireHubEui(array $data): ?string
    {
        if (empty($data[self::KEY_HUB_EUI])) {
            return null;
        }
        if (!is_string($data[self::KEY_HUB_EUI])) {
            return null;
        }

        return $data[self::KEY_HUB_EUI];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubDriverInterface>
     */
    private function transformListHubDriver(array $data): array
    {
        return array_values(array_map(fn (array $item): HubDriverInterface => $this->hubDriverTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
