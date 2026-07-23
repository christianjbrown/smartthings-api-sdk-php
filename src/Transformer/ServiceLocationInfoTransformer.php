<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\ServiceLocationInfo;
use ChristianBrown\SmartThings\Model\ServiceLocationInfoInterface;

use function is_array;
use function is_float;
use function is_int;
use function is_string;
use function sprintf;

final class ServiceLocationInfoTransformer implements ServiceLocationInfoTransformerInterface
{
    private ServiceLocationInfoSubscriptionsTransformerInterface $serviceLocationInfoSubscriptionsTransformer;

    public function __construct(ServiceLocationInfoSubscriptionsTransformerInterface $serviceLocationInfoSubscriptionsTransformer)
    {
        $this->serviceLocationInfoSubscriptionsTransformer = $serviceLocationInfoSubscriptionsTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ServiceLocationInfoInterface
    {
        if (empty($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        if (!is_string($data[self::KEY_LOCATION_ID])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LOCATION_ID));
        }
        $info = new ServiceLocationInfo($data[self::KEY_LOCATION_ID]);

        self::applyCity($info, $data);
        self::applyLatitude($info, $data);
        self::applyLongitude($info, $data);
        $this->applySubscriptions($info, $data);

        return $info;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCity(ServiceLocationInfo $info, array $data): void
    {
        if (empty($data[self::KEY_CITY])) {
            return;
        }
        if (!is_string($data[self::KEY_CITY])) {
            return;
        }
        $info->setCity($data[self::KEY_CITY]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLatitude(ServiceLocationInfo $info, array $data): void
    {
        if (!isset($data[self::KEY_LATITUDE])) {
            return;
        }
        $latitude = $data[self::KEY_LATITUDE];
        if (is_int($latitude)) {
            $info->setLatitude((float) $latitude);

            return;
        }
        if (is_float($latitude)) {
            $info->setLatitude($latitude);
        }
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLongitude(ServiceLocationInfo $info, array $data): void
    {
        if (!isset($data[self::KEY_LONGITUDE])) {
            return;
        }
        $longitude = $data[self::KEY_LONGITUDE];
        if (is_int($longitude)) {
            $info->setLongitude((float) $longitude);

            return;
        }
        if (is_float($longitude)) {
            $info->setLongitude($longitude);
        }
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySubscriptions(ServiceLocationInfo $info, array $data): void
    {
        if (empty($data[self::KEY_SUBSCRIPTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_SUBSCRIPTIONS])) {
            return;
        }
        $info->setSubscriptions($this->serviceLocationInfoSubscriptionsTransformer->transform($data[self::KEY_SUBSCRIPTIONS]));
    }
}
