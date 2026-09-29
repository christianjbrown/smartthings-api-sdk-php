<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;

use function array_filter;

final class PlayPauseCommandSerializer implements PlayPauseCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PlayPauseCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_PLAY => $model->getPlay(),
            self::KEY_PAUSE => $model->getPause(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
