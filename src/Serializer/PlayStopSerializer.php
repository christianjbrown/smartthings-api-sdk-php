<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayStopCommandInterface;

use ChristianBrown\SmartThings\Model\PlayStopInterface;
use ChristianBrown\SmartThings\Model\PlayStopStateInterface;

use function array_filter;

final class PlayStopSerializer implements PlayStopSerializerInterface
{
    private PlayStopCommandSerializerInterface $playStopCommandSerializer;
    private PlayStopStateSerializerInterface $playStopStateSerializer;

    public function __construct(PlayStopCommandSerializerInterface $playStopCommandSerializer, PlayStopStateSerializerInterface $playStopStateSerializer)
    {
        $this->playStopCommandSerializer = $playStopCommandSerializer;
        $this->playStopStateSerializer = $playStopStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PlayStopInterface $model): array
    {
        return array_filter([
            self::KEY_COMMAND => $this->serializeOptionalPlayStopCommand($model->getCommand()),
            self::KEY_STATE => $this->serializeOptionalPlayStopState($model->getState()),
        ], static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayStopCommand(?PlayStopCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playStopCommandSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayStopState(?PlayStopStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playStopStateSerializer->serialize($value);
    }
}
