<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\DeviceOperandInterface;

use function array_filter;

/**
 * Serializes DeviceOperandInterface into its JSON body.
 */
final class DeviceOperandNodeSerializer implements DeviceOperandNodeSerializerInterface
{
    /**
     * @param DeviceOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_DEVICES => $value->getDevices(),
            self::KEY_COMPONENT => $value->getComponent(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_ATTRIBUTE => $value->getAttribute(),
            self::KEY_PATH => $value->getPath(),
            self::KEY_AGGREGATION => $value->getAggregation(),
            self::KEY_TRIGGER => $value->getTrigger(),
        ]);
    }

    /**
     * Omits null optionals rather than sending them as explicit nulls.
     *
     * @param mixed[] $serialized
     *
     * @return mixed[]
     */
    private static function filter(array $serialized): array
    {
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
