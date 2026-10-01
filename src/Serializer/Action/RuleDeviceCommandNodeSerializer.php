<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\Model\RuleDeviceCommandInterface;

use function array_filter;

/**
 * Serializes RuleDeviceCommandInterface into its JSON body.
 */
final class RuleDeviceCommandNodeSerializer implements RuleDeviceCommandNodeSerializerInterface
{
    /**
     * @param RuleDeviceCommandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array
    {
        return self::filter([
            self::KEY_COMPONENT => $value->getComponent(),
            self::KEY_CAPABILITY => $value->getCapability(),
            self::KEY_COMMAND => $value->getCommand(),
            self::KEY_ARGUMENTS => $value->getArguments(),
            self::KEY_COMMAND_ID => $value->getCommandId(),
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
