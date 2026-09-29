<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;

interface ExcludedActionItemIdSerializerInterface
{
    public const string KEY_EXCLUDE = 'exclude';
    public const string KEY_ID = 'id';
    public const string KEY_VALUE = 'value';

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedActionItemIdInterface $model): array;
}
