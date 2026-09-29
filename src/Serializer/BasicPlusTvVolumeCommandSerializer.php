<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

use function array_filter;

final class BasicPlusTvVolumeCommandSerializer implements BasicPlusTvVolumeCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvVolumeCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_INCREASE => $model->getIncrease(),
            self::KEY_DECREASE => $model->getDecrease(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
