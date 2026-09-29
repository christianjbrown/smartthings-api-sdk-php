<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;

use function array_filter;

final class TextFieldForArgumentSerializer implements TextFieldForArgumentSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForArgumentInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_RANGE => $model->getRange(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
