<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StatelessPowerToggleForDashboardInterface;

use function array_filter;

final class StatelessPowerToggleForDashboardSerializer implements StatelessPowerToggleForDashboardSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(StatelessPowerToggleForDashboardInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT => $model->getArgument(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
