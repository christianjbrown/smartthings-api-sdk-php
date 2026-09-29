<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;

final class SupportedValuesForDynamicListValueMapSerializer implements SupportedValuesForDynamicListValueMapSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(SupportedValuesForDynamicListValueMapInterface $model): array
    {
        return [
            self::KEY_KEY => $model->getKey(),
            self::KEY_VALUE => $model->getValue(),
        ];
    }
}
