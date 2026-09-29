<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ToggleSwitchForDashboardCommandInterface;

use function array_filter;

final class ToggleSwitchForDashboardCommandSerializer implements ToggleSwitchForDashboardCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ToggleSwitchForDashboardCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_ON => $model->getOn(),
            self::KEY_OFF => $model->getOff(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
