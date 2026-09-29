<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItemInterface;

use function array_filter;

final class BasicPlusProgressBarsBarItemSerializer implements BasicPlusProgressBarsBarItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusProgressBarsBarItemInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_RANGE => $model->getRange(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
