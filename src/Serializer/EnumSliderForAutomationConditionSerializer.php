<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionSupportedOperatorsItemInterface;

use function array_filter;
use function array_map;

final class EnumSliderForAutomationConditionSerializer implements EnumSliderForAutomationConditionSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;
    private EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface $enumSliderForAutomationConditionSupportedOperatorsItemSerializer;

    public function __construct(AlternativeItemSerializerInterface $alternativeItemSerializer, EnumSliderForAutomationConditionSupportedOperatorsItemSerializerInterface $enumSliderForAutomationConditionSupportedOperatorsItemSerializer)
    {
        $this->alternativeItemSerializer = $alternativeItemSerializer;
        $this->enumSliderForAutomationConditionSupportedOperatorsItemSerializer = $enumSliderForAutomationConditionSupportedOperatorsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(EnumSliderForAutomationConditionInterface $model): array
    {
        $serialized = [
            self::KEY_ALTERNATIVES => $this->serializeAlternatives($model->getAlternatives()),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_SUPPORTED_OPERATORS => $this->serializeSupportedOperators($model->getSupportedOperators()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, AlternativeItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeAlternatives(array $values): array
    {
        return array_map(fn (AlternativeItemInterface $item): array => $this->alternativeItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, EnumSliderForAutomationConditionSupportedOperatorsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeSupportedOperators(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (EnumSliderForAutomationConditionSupportedOperatorsItemInterface $item): array => $this->enumSliderForAutomationConditionSupportedOperatorsItemSerializer->serialize($item), $values);
    }
}
