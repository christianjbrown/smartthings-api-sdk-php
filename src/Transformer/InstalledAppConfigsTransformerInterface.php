<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\InstalledAppConfigInterface;

interface InstalledAppConfigsTransformerInterface
{
    public const string ARRAY_NAME = 'installed app config';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstalledAppConfigInterface>
     */
    public function transform(array $data): array;
}
