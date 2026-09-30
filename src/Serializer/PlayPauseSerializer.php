<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayPauseCommandInterface;

use ChristianBrown\SmartThings\Model\PlayPauseInterface;
use ChristianBrown\SmartThings\Model\PlayPauseStateInterface;

use function array_filter;

final class PlayPauseSerializer implements PlayPauseSerializerInterface
{
    private PlayPauseCommandSerializerInterface $playPauseCommandSerializer;
    private PlayPauseStateSerializerInterface $playPauseStateSerializer;

    public function __construct(PlayPauseCommandSerializerInterface $playPauseCommandSerializer, PlayPauseStateSerializerInterface $playPauseStateSerializer)
    {
        $this->playPauseCommandSerializer = $playPauseCommandSerializer;
        $this->playPauseStateSerializer = $playPauseStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PlayPauseInterface $model): array
    {
        return array_filter([
            self::KEY_COMMAND => $this->serializeOptionalPlayPauseCommand($model->getCommand()),
            self::KEY_STATE => $this->serializeOptionalPlayPauseState($model->getState()),
        ], static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayPauseCommand(?PlayPauseCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playPauseCommandSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPlayPauseState(?PlayPauseStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->playPauseStateSerializer->serialize($value);
    }
}
