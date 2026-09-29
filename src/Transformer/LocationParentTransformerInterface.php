<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationParentInterface;

interface LocationParentTransformerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_TYPE = 'type';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationParentInterface;
}
