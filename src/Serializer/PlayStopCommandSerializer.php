<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;

use function array_filter;

final class PlayStopCommandSerializer implements PlayStopCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PlayStopCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_PLAY => $model->getPlay(),
            self::KEY_STOP => $model->getStop(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
