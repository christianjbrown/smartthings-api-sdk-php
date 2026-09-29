<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadCommandInterface;

use function array_filter;

final class BasicPlusTvDirectionalPadCommandSerializer implements BasicPlusTvDirectionalPadCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvDirectionalPadCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_UP => $model->getUp(),
            self::KEY_DOWN => $model->getDown(),
            self::KEY_LEFT => $model->getLeft(),
            self::KEY_RIGHT => $model->getRight(),
            self::KEY_OK => $model->getOk(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
