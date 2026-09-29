<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\NumberFieldForArgumentInterface;

use function array_filter;

final class NumberFieldForArgumentSerializer implements NumberFieldForArgumentSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldForArgumentInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_UNIT => $model->getUnit(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
