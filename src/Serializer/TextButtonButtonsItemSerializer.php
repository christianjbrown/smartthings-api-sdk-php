<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;

use function array_filter;

final class TextButtonButtonsItemSerializer implements TextButtonButtonsItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(TextButtonButtonsItemInterface $model): array
    {
        $serialized = [
            self::KEY_KEY => $model->getKey(),
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_STATE => $model->getState(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
