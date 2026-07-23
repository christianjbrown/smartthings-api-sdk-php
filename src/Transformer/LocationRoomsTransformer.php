<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\LocationRoomInterface;

use function array_values;
use function count;
use function sprintf;

final class LocationRoomsTransformer implements LocationRoomsTransformerInterface
{
    private LocationRoomTransformerInterface $roomTransformer;

    public function __construct(LocationRoomTransformerInterface $roomTransformer)
    {
        $this->roomTransformer = $roomTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LocationRoomInterface>
     */
    public function transform(array $data): array
    {
        $rooms = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $roomData = $values[$i];
            if (!is_array($roomData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $rooms[] = $this->roomTransformer->transform($roomData);
        }

        return $rooms;
    }
}
