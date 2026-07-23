<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationRoomInterface;

interface LocationRoomsTransformerInterface
{
    public const string ARRAY_NAME = 'room';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocationRoomInterface>
     */
    public function transform(array $data): array;
}
