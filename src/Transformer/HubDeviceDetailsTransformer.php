<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDeviceDetails;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataInterface;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsInterface;
use ChristianBrown\SmartThings\Model\HubDriverInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

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
    private static function requireDriverId(array $data): string
    {
        if (empty($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }
        if (!is_string($data[self::KEY_DRIVER_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DRIVER_ID));
        }

        return $data[self::KEY_DRIVER_ID];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireFirmwareVersion(array $data): string
    {
        if (empty($data[self::KEY_FIRMWARE_VERSION])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_FIRMWARE_VERSION));
        }
        if (!is_string($data[self::KEY_FIRMWARE_VERSION])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_FIRMWARE_VERSION));
        }

        return $data[self::KEY_FIRMWARE_VERSION];
    }

    /**
     * @param mixed[] $data
     */
    private function requireHubData(array $data): HubDeviceDetailsHubDataInterface
    {
        if (!isset($data[self::KEY_HUB_DATA])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_HUB_DATA));
        }
        if (!is_array($data[self::KEY_HUB_DATA])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_HUB_DATA));
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
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_HUB_DRIVERS));
        }
        if (!is_array($data[self::KEY_HUB_DRIVERS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_HUB_DRIVERS));
        }

        return $this->transformListHubDriver($data[self::KEY_HUB_DRIVERS]);
    }

    /**
     * @param mixed[] $data
     */
    private static function requireHubEui(array $data): string
    {
        if (empty($data[self::KEY_HUB_EUI])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_HUB_EUI));
        }
        if (!is_string($data[self::KEY_HUB_EUI])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_HUB_EUI));
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
