<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PlayStopInterface;

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
        return [
            self::KEY_COMMAND => $this->playStopCommandSerializer->serialize($model->getCommand()),
            self::KEY_STATE => $this->playStopStateSerializer->serialize($model->getState()),
        ];
    }
}
