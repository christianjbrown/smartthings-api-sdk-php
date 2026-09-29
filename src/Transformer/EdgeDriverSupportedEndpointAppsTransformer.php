<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointApps;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsAppsItemInterface;
use ChristianBrown\SmartThings\Model\EdgeDriverSupportedEndpointAppsInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function sprintf;

final class EdgeDriverSupportedEndpointAppsTransformer implements EdgeDriverSupportedEndpointAppsTransformerInterface
{
    private EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface $edgeDriverSupportedEndpointAppsAppsItemTransformer;

    public function __construct(EdgeDriverSupportedEndpointAppsAppsItemTransformerInterface $edgeDriverSupportedEndpointAppsAppsItemTransformer)
    {
        $this->edgeDriverSupportedEndpointAppsAppsItemTransformer = $edgeDriverSupportedEndpointAppsAppsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): EdgeDriverSupportedEndpointAppsInterface
    {
        $model = new EdgeDriverSupportedEndpointApps($this->requireApps($data));

        return $model;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface>
     */
    private function requireApps(array $data): array
    {
        if (!isset($data[self::KEY_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_APPS));
        }
        if (!is_array($data[self::KEY_APPS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_APPS));
        }

        return $this->transformListEdgeDriverSupportedEndpointAppsAppsItem($data[self::KEY_APPS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, EdgeDriverSupportedEndpointAppsAppsItemInterface>
     */
    private function transformListEdgeDriverSupportedEndpointAppsAppsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): EdgeDriverSupportedEndpointAppsAppsItemInterface => $this->edgeDriverSupportedEndpointAppsAppsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
