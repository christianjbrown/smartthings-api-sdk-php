<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DeviceCategoryInterface;

final class DeviceCategorySerializer implements DeviceCategorySerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(DeviceCategoryInterface $model): array
    {
        return [
            self::KEY_NAME => $model->getName(),
            self::KEY_CATEGORY_TYPE => $model->getCategoryType(),
        ];
    }
}
