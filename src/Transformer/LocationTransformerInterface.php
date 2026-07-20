<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationInterface;

interface LocationTransformerInterface
{
    public const string KEY_LOCATION_ID = 'locationId';
    public const string KEY_NAME = 'name';
    public const string UNEXPECTED_STRING_SPRINTF = '%s not set or not a string';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationInterface;
}
