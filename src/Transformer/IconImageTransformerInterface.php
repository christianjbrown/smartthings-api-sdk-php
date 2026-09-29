<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\IconImageInterface;

interface IconImageTransformerInterface
{
    public const string KEY_URL = 'url';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): IconImageInterface;
}
