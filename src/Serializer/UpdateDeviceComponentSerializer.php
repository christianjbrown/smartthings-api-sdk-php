<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\UpdateDeviceComponentInterface;

use function array_filter;

final class UpdateDeviceComponentSerializer implements UpdateDeviceComponentSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(UpdateDeviceComponentInterface $model): array
    {
        $serialized = [
            self::KEY_ID => $model->getId(),
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_ICON => $model->getIcon(),
            self::KEY_CATEGORIES => $model->getCategories(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
