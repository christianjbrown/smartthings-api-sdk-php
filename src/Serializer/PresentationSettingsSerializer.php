<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\PresentationSettingsInterface;
use ChristianBrown\SmartThings\Model\PresentationSettingsTemperatureConversionsItemInterface;

use function array_filter;
use function array_map;

final class PresentationSettingsSerializer implements PresentationSettingsSerializerInterface
{
    private PresentationSettingsTemperatureConversionsItemSerializerInterface $presentationSettingsTemperatureConversionsItemSerializer;

    public function __construct(PresentationSettingsTemperatureConversionsItemSerializerInterface $presentationSettingsTemperatureConversionsItemSerializer)
    {
        $this->presentationSettingsTemperatureConversionsItemSerializer = $presentationSettingsTemperatureConversionsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PresentationSettingsInterface $model): array
    {
        $serialized = [
            self::KEY_TEMPERATURE_CONVERSIONS => $this->serializeTemperatureConversions($model->getTemperatureConversions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, PresentationSettingsTemperatureConversionsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeTemperatureConversions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (PresentationSettingsTemperatureConversionsItemInterface $item): array => $this->presentationSettingsTemperatureConversionsItemSerializer->serialize($item), $values);
    }
}
