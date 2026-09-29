<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;

use function array_filter;

final class TextFieldForAutomationActionSerializer implements TextFieldForAutomationActionSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForAutomationActionInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_RANGE => $model->getRange(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
