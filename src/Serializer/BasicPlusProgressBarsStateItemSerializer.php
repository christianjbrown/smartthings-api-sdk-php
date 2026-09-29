<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\DeviceConfigEntryForDashboardStateFormatInfoItemInterface;

use function array_filter;
use function array_map;

final class BasicPlusProgressBarsStateItemSerializer implements BasicPlusProgressBarsStateItemSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;
    private DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemSerializer;

    public function __construct(AlternativeItemSerializerInterface $alternativeItemSerializer, DeviceConfigEntryForDashboardStateFormatInfoItemSerializerInterface $deviceConfigEntryForDashboardStateFormatInfoItemSerializer)
    {
        $this->alternativeItemSerializer = $alternativeItemSerializer;
        $this->deviceConfigEntryForDashboardStateFormatInfoItemSerializer = $deviceConfigEntryForDashboardStateFormatInfoItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusProgressBarsStateItemInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_ALTERNATIVES => $this->serializeAlternatives($model->getAlternatives()),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_FORMAT_INFO => $this->serializeFormatInfo($model->getFormatInfo()),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_PLACEMENT => $model->getPlacement(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeAlternatives(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (AlternativeItemInterface $item): array => $this->alternativeItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, DeviceConfigEntryForDashboardStateFormatInfoItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeFormatInfo(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DeviceConfigEntryForDashboardStateFormatInfoItemInterface $item): array => $this->deviceConfigEntryForDashboardStateFormatInfoItemSerializer->serialize($item), $values);
    }
}
