<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\HubInstalledDriverInterface;

interface HubInstalledDriversTransformerInterface
{
    public const string ARRAY_NAME = 'installedDriver';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, HubInstalledDriverInterface>
     */
    public function transform(array $data): array;
}
