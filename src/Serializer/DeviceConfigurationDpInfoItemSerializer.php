<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemArgumentsItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigurationDpInfoItemInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationDpInfoItemSerializer implements DeviceConfigurationDpInfoItemSerializerInterface
{
    private DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface $deviceConfigurationDpInfoItemArgumentsItemSerializer;

    public function __construct(DeviceConfigurationDpInfoItemArgumentsItemSerializerInterface $deviceConfigurationDpInfoItemArgumentsItemSerializer)
    {
        $this->deviceConfigurationDpInfoItemArgumentsItemSerializer = $deviceConfigurationDpInfoItemArgumentsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationDpInfoItemInterface $model): array
    {
        $serialized = [
            self::KEY_OS => $model->getOs(),
            self::KEY_DP_URI => $model->getDpUri(),
            self::KEY_SERVER_DP_URI => $model->getServerDpUri(),
            self::KEY_OPERATING_MODE => $model->getOperatingMode(),
            self::KEY_ARGUMENTS => $this->serializeArguments($model->getArguments()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DeviceConfigurationDpInfoItemArgumentsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeArguments(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigurationDpInfoItemArgumentsItemInterface $item): array => $this->deviceConfigurationDpInfoItemArgumentsItemSerializer->serialize($item), $values);
    }
}
