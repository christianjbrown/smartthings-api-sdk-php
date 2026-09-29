<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\MatterEndpoint;
use ChristianBrown\SmartThings\Model\MatterEndpointDeviceTypeInterface;
use ChristianBrown\SmartThings\Model\MatterEndpointInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;

final class MatterEndpointTransformer implements MatterEndpointTransformerInterface
{
    private MatterEndpointDeviceTypeTransformerInterface $matterEndpointDeviceTypeTransformer;

    public function __construct(MatterEndpointDeviceTypeTransformerInterface $matterEndpointDeviceTypeTransformer)
    {
        $this->matterEndpointDeviceTypeTransformer = $matterEndpointDeviceTypeTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MatterEndpointInterface
    {
        $model = new MatterEndpoint();

        self::applyEndpointId($model, $data);
        $this->applyDeviceTypes($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDeviceTypes(MatterEndpoint $model, array $data): void
    {
        if (!isset($data[self::KEY_DEVICE_TYPES])) {
            return;
        }
        if (!is_array($data[self::KEY_DEVICE_TYPES])) {
            return;
        }
        $model->setDeviceTypes($this->transformListMatterEndpointDeviceType($data[self::KEY_DEVICE_TYPES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEndpointId(MatterEndpoint $model, array $data): void
    {
        if (!isset($data[self::KEY_ENDPOINT_ID])) {
            return;
        }
        if (!is_int($data[self::KEY_ENDPOINT_ID])) {
            return;
        }
        $model->setEndpointId($data[self::KEY_ENDPOINT_ID]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, MatterEndpointDeviceTypeInterface>
     */
    private function transformListMatterEndpointDeviceType(array $data): array
    {
        return array_values(array_map(fn (array $item): MatterEndpointDeviceTypeInterface => $this->matterEndpointDeviceTypeTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
