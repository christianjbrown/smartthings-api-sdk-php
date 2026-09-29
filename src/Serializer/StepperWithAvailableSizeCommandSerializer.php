<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeCommandInterface;

use function array_filter;

final class StepperWithAvailableSizeCommandSerializer implements StepperWithAvailableSizeCommandSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(StepperWithAvailableSizeCommandInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_INCREASE => $model->getIncrease(),
            self::KEY_DECREASE => $model->getDecrease(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
