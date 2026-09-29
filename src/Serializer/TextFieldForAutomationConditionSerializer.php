<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;

use function array_filter;

final class TextFieldForAutomationConditionSerializer implements TextFieldForAutomationConditionSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(TextFieldForAutomationConditionInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_RANGE => $model->getRange(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
