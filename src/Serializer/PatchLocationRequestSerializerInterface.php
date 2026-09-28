<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PatchLocationRequestInterface;

interface PatchLocationRequestSerializerInterface
{
    public const string KEY_LATITUDE = 'latitude';
    public const string KEY_LONGITUDE = 'longitude';
    public const string KEY_REGION_RADIUS = 'regionRadius';
    public const string KEY_TO_NULL = 'toNull';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(PatchLocationRequestInterface $request): array;
}
