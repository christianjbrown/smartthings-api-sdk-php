<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\Location;
use ChristianBrown\SmartThings\Model\LocationInterface;

use function is_string;
use function sprintf;

final class LocationTransformer implements LocationTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        $location = new Location($data[self::KEY_LOCATION_ID]);

        $this->applyName($location, $data);

        return $location;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyName(Location $location, array $data): void
    {
        if (empty($data[self::KEY_NAME])) {
            return;
        }
        if (!is_string($data[self::KEY_NAME])) {
            return;
        }
        $location->setName($data[self::KEY_NAME]);
    }
}
