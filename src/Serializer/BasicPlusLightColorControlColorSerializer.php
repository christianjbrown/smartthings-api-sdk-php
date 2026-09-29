<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlColorInterface;

use function array_filter;

final class BasicPlusLightColorControlColorSerializer implements BasicPlusLightColorControlColorSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightColorControlColorInterface $model): array
    {
        $serialized = [
            self::KEY_HUE => $model->getHue(),
            self::KEY_SATURATION => $model->getSaturation(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
