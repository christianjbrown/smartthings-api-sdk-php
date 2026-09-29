<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ButtonForTvInterface;

use function array_filter;

final class ButtonForTvSerializer implements ButtonForTvSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ButtonForTvInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT => $model->getArgument(),
            self::KEY_ICON_URL => $model->getIconUrl(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
