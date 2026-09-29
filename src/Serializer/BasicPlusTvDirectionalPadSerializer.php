<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadInterface;

use function array_filter;

final class BasicPlusTvDirectionalPadSerializer implements BasicPlusTvDirectionalPadSerializerInterface
{
    private BasicPlusTvDirectionalPadCommandSerializerInterface $basicPlusTvDirectionalPadCommandSerializer;

    public function __construct(BasicPlusTvDirectionalPadCommandSerializerInterface $basicPlusTvDirectionalPadCommandSerializer)
    {
        $this->basicPlusTvDirectionalPadCommandSerializer = $basicPlusTvDirectionalPadCommandSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvDirectionalPadInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_COMMAND => $this->basicPlusTvDirectionalPadCommandSerializer->serialize($model->getCommand()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
