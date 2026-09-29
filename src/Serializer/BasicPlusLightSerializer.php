<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusLightColorControlInterface;
use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;
use ChristianBrown\SmartThings\Model\SliderForLightInterface;

use function array_filter;

final class BasicPlusLightSerializer implements BasicPlusLightSerializerInterface
{
    private BasicPlusLightColorControlSerializerInterface $basicPlusLightColorControlSerializer;
    private SliderForLightSerializerInterface $sliderForLightSerializer;

    public function __construct(SliderForLightSerializerInterface $sliderForLightSerializer, BasicPlusLightColorControlSerializerInterface $basicPlusLightColorControlSerializer)
    {
        $this->sliderForLightSerializer = $sliderForLightSerializer;
        $this->basicPlusLightColorControlSerializer = $basicPlusLightColorControlSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusLightInterface $model): array
    {
        $serialized = [
            self::KEY_DIMMER => $this->sliderForLightSerializer->serialize($model->getDimmer()),
            self::KEY_COLOR_TEMPERATURE => $this->serializeOptionalColorTemperature($model->getColorTemperature()),
            self::KEY_COLOR_CONTROL => $this->serializeOptionalColorControl($model->getColorControl()),
            self::KEY_HIDE_DASHBOARD_ACTIONS => $model->getHideDashboardActions(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalColorControl(?BasicPlusLightColorControlInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusLightColorControlSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalColorTemperature(?SliderForLightInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderForLightSerializer->serialize($value);
    }
}
