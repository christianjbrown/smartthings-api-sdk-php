<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\IndoorMapInterface;

use function array_filter;

final class IndoorMapSerializer implements IndoorMapSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(IndoorMapInterface $model): array
    {
        $serialized = [
            self::KEY_COORDINATES => $model->getCoordinates(),
            self::KEY_ROTATION => $model->getRotation(),
            self::KEY_VISIBLE => $model->getVisible(),
            self::KEY_DATA => $model->getData(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
