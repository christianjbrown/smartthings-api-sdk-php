<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IndoorMapInterface;

interface IndoorMapTransformerInterface
{
    public const string KEY_COORDINATES = 'coordinates';
    public const string KEY_DATA = 'data';
    public const string KEY_ROTATION = 'rotation';
    public const string KEY_VISIBLE = 'visible';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IndoorMapInterface;
}
