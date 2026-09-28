<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DeviceCommandResultInterface;

interface DeviceCommandResultsTransformerInterface
{
    public const string ARRAY_NAME = 'command result';
    public const string UNEXPECTED_ARRAY_SPRINTF = '%s not set or not an array';

    /**
     * @param mixed[] $data
     *
     * @return array<int, DeviceCommandResultInterface>
     */
    public function transform(array $data): array;
}
