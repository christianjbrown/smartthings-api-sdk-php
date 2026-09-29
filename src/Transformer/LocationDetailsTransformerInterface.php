<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\LocationDetailsInterface;

interface LocationDetailsTransformerInterface
{
    public const string KEY_PARENT = 'parent';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): LocationDetailsInterface;
}
