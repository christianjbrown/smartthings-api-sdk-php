<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PatchItemInterface;

interface PatchItemSerializerInterface
{
    public const string KEY_OP = 'op';
    public const string KEY_PATH = 'path';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(PatchItemInterface $model): array;
}
