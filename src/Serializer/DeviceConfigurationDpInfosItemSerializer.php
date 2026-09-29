<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfosItemInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationDpInfosItemSerializer implements DeviceConfigurationDpInfosItemSerializerInterface
{
    private DeviceConfigurationDpInfoItemSerializerInterface $deviceConfigurationDpInfoItemSerializer;

    public function __construct(DeviceConfigurationDpInfoItemSerializerInterface $deviceConfigurationDpInfoItemSerializer)
    {
        $this->deviceConfigurationDpInfoItemSerializer = $deviceConfigurationDpInfoItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfosItemInterface $model): array
    {
        $serialized = [
            self::KEY_ST_PLUGIN_API_VERSION => $model->getStPluginApiVersion(),
            self::KEY_DP_INFO => $this->serializeDpInfo($model->getDpInfo()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, DeviceConfigurationDpInfoItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeDpInfo(array $values): array
    {
        return array_map(fn (DeviceConfigurationDpInfoItemInterface $item): array => $this->deviceConfigurationDpInfoItemSerializer->serialize($item), $values);
    }
}
