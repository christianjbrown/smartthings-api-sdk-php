<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayPauseInterface;

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
        return [
            self::KEY_COMMAND => $this->playPauseCommandSerializer->serialize($model->getCommand()),
            self::KEY_STATE => $this->playPauseStateSerializer->serialize($model->getState()),
        ];
    }
}
