<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppIconImageInterface;

interface InstalledAppIconImageTransformerInterface
{
    public const string KEY_URL = 'url';

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): InstalledAppIconImageInterface;
}
