<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;

use function array_filter;

final class AlternativeItemSerializer implements AlternativeItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(AlternativeItemInterface $model): array
    {
        $serialized = [
            self::KEY_KEY => $model->getKey(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_TYPE => $model->getType(),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_DESCRIPTION => $model->getDescription(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
