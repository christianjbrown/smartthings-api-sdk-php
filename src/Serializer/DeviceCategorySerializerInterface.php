<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;

interface DeviceCategorySerializerInterface
{
    public const string KEY_CATEGORY_TYPE = 'categoryType';
    public const string KEY_NAME = 'name';

    /**
     * @return mixed[]
     */
    public function serialize(DeviceCategoryInterface $model): array;
}
