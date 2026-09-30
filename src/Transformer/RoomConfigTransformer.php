<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\RoomConfig;
use ChristianBrown\SmartThings\Model\RoomConfigInterface;

final class RoomConfigTransformer implements RoomConfigTransformerInterface
{
    private ValueReaderInterface $valueReader;

    public function __construct(ValueReaderInterface $valueReader)
    {
        $this->valueReader = $valueReader;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): RoomConfigInterface
    {
        return (new RoomConfig())
            ->setRoomId($this->valueReader->string($data, self::KEY_ROOM_ID))
            ->setPermissions($this->valueReader->strings($data, self::KEY_PERMISSIONS));
    }
}
