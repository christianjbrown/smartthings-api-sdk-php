<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\CapabilityConfigurationValueInterface;

use function array_filter;

final class CapabilityConfigurationValueSerializer implements CapabilityConfigurationValueSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(CapabilityConfigurationValueInterface $model): array
    {
        $serialized = [
            self::KEY_KEY => $model->getKey(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_ENABLED_VALUES => $model->getEnabledValues(),
            self::KEY_STEP => $model->getStep(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
