<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\LocationParentInterface;

interface LocationParentSerializerInterface
{
    public const string KEY_ID = 'id';
    public const string KEY_TYPE = 'type';

    /**
     * @return array<string, string>
     */
    public function serialize(LocationParentInterface $parent): array;
}
