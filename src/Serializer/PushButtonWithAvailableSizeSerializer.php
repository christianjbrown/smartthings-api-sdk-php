<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;

use function array_filter;

final class PushButtonWithAvailableSizeSerializer implements PushButtonWithAvailableSizeSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PushButtonWithAvailableSizeInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT => $model->getArgument(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_AVAILABLE_SIZES => $model->getAvailableSizes(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
