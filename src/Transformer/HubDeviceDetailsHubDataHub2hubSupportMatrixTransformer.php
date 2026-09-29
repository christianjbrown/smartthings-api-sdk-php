<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrix;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface;
use ChristianBrown\SmartThings\Model\HubDeviceDetailsHubDataHub2hubSupportMatrixInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function sprintf;

final class HubDeviceDetailsHubDataHub2hubSupportMatrixTransformer implements HubDeviceDetailsHubDataHub2hubSupportMatrixTransformerInterface
{
    private HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer;

    public function __construct(HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformerInterface $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer)
    {
        $this->hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer = $hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): HubDeviceDetailsHubDataHub2hubSupportMatrixInterface
    {
        $model = new HubDeviceDetailsHubDataHub2hubSupportMatrix($this->requireCapabilities($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface>
     */
    private function requireCapabilities(array $data): array
    {
        if (!isset($data[self::KEY_CAPABILITIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_CAPABILITIES));
        }
        if (!is_array($data[self::KEY_CAPABILITIES])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_CAPABILITIES));
        }

        return $this->transformListHubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem($data[self::KEY_CAPABILITIES]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface>
     */
    private function transformListHubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItem(array $data): array
    {
        return array_values(array_map(fn (array $item): HubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemInterface => $this->hubDeviceDetailsHubDataHub2hubSupportMatrixCapabilitiesItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
