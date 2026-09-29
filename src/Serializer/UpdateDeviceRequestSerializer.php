<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\IndoorMapInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceComponentInterface;
use ChristianBrown\SmartThings\Model\UpdateDeviceRequestInterface;

use function array_filter;
use function array_map;

final class UpdateDeviceRequestSerializer implements UpdateDeviceRequestSerializerInterface
{
    private IndoorMapSerializerInterface $indoorMapSerializer;
    private UpdateDeviceComponentSerializerInterface $updateDeviceComponentSerializer;

    public function __construct(UpdateDeviceComponentSerializerInterface $updateDeviceComponentSerializer, IndoorMapSerializerInterface $indoorMapSerializer)
    {
        $this->updateDeviceComponentSerializer = $updateDeviceComponentSerializer;
        $this->indoorMapSerializer = $indoorMapSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceRequestInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_LOCATION_ID => $model->getLocationId(),
            self::KEY_ROOM_ID => $model->getRoomId(),
            self::KEY_COMPONENTS => $this->serializeComponents($model->getComponents()),
            self::KEY_INDOOR_MAP => $this->serializeOptionalIndoorMap($model->getIndoorMap()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, UpdateDeviceComponentInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeComponents(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (UpdateDeviceComponentInterface $item): array => $this->updateDeviceComponentSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalIndoorMap(?IndoorMapInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->indoorMapSerializer->serialize($value);
    }
}
