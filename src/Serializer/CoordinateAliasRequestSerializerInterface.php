<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CoordinateAliasRequestInterface;

interface CoordinateAliasRequestSerializerInterface
{
    public const string KEY_LATITUDE = 'latitude';
    public const string KEY_LONGITUDE = 'longitude';
    public const string KEY_REGION_RADIUS = 'regionRadius';

    /**
     * @return mixed[]
     */
    public function serialize(CoordinateAliasRequestInterface $request): array;
}
