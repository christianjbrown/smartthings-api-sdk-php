<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeCommandInterface;

use function array_filter;

final class BasicPlusTvChannelSerializer implements BasicPlusTvChannelSerializerInterface
{
    private BasicPlusTvVolumeCommandSerializerInterface $basicPlusTvVolumeCommandSerializer;

    public function __construct(BasicPlusTvVolumeCommandSerializerInterface $basicPlusTvVolumeCommandSerializer)
    {
        $this->basicPlusTvVolumeCommandSerializer = $basicPlusTvVolumeCommandSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvChannelInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_COMMAND => $this->serializeOptionalBasicPlusTvVolumeCommand($model->getCommand()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalBasicPlusTvVolumeCommand(?BasicPlusTvVolumeCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusTvVolumeCommandSerializer->serialize($value);
    }
}
