<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;

use function array_filter;

final class BasicPlusCameraImageSerializer implements BasicPlusCameraImageSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraImageInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_VALUE => $model->getValue(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
