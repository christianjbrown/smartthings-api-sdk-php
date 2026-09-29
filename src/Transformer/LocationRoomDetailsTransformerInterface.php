<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoomDetailsInterface;

interface LocationRoomDetailsTransformerInterface
{
    public const string KEY_INDOOR_MAP = 'indoorMap';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationRoomDetailsInterface;
}
