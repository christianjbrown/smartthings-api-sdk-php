<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;

use function array_filter;

final class EmptyWithAvailableSizeSerializer implements EmptyWithAvailableSizeSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(EmptyWithAvailableSizeInterface $model): array
    {
        $serialized = [
            self::KEY_AVAILABLE_SIZES => $model->getAvailableSizes(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
