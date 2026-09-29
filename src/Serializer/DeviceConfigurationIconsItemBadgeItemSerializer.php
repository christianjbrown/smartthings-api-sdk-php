<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceConfigurationIconsItemBadgeItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class DeviceConfigurationIconsItemBadgeItemSerializer implements DeviceConfigurationIconsItemBadgeItemSerializerInterface
{
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DeviceConfigurationIconsItemBadgeItemInterface $model): array
    {
        $serialized = [
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeVisibleConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (VisibleConditionInterface $item): array => $this->visibleConditionSerializer->serialize($item), $values);
    }
}
