<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PreferenceDefinitionInterface;

use function array_filter;

final class PreferenceDefinitionSerializer implements PreferenceDefinitionSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PreferenceDefinitionInterface $model): array
    {
        $serialized = [
            self::KEY_MINIMUM => $model->getMinimum(),
            self::KEY_MAXIMUM => $model->getMaximum(),
            self::KEY_MIN_LENGTH => $model->getMinLength(),
            self::KEY_MAX_LENGTH => $model->getMaxLength(),
            self::KEY_DEFAULT => $model->getDefaultValue(),
            self::KEY_STRING_TYPE => $model->getStringType(),
            self::KEY_OPTIONS => $model->getOptions(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
