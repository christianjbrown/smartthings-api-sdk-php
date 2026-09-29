<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;

use function array_filter;

final class PresentationSettingsTemperatureConversionsItemSerializer implements PresentationSettingsTemperatureConversionsItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(PresentationSettingsTemperatureConversionsItemInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_UNIT => $model->getUnit(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
