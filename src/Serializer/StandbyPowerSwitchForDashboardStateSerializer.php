<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\StandbyPowerSwitchForDashboardStateInterface;

use function array_filter;
use function array_map;

final class StandbyPowerSwitchForDashboardStateSerializer implements StandbyPowerSwitchForDashboardStateSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;

    public function __construct(AlternativeItemSerializerInterface $alternativeItemSerializer)
    {
        $this->alternativeItemSerializer = $alternativeItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(StandbyPowerSwitchForDashboardStateInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_ON => $model->getOn(),
            self::KEY_OFF => $model->getOff(),
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_ALTERNATIVES => $this->serializeAlternatives($model->getAlternatives()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeAlternatives(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (AlternativeItemInterface $item): array => $this->alternativeItemSerializer->serialize($item), $values);
    }
}
