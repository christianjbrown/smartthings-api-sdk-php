<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldInterface;

use function array_filter;

final class NumberFieldSerializer implements NumberFieldSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_UNIT => $model->getUnit(),
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
