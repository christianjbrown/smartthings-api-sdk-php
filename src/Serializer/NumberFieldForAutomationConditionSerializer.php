<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;

use function array_filter;
use function array_map;

final class NumberFieldForAutomationConditionSerializer implements NumberFieldForAutomationConditionSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;

    public function __construct(AlternativeItemSerializerInterface $alternativeItemSerializer)
    {
        $this->alternativeItemSerializer = $alternativeItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(NumberFieldForAutomationConditionInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_UNIT => $model->getUnit(),
            self::KEY_RANGE => $model->getRange(),
            self::KEY_ALTERNATIVES => $this->serializeAlternatives($model->getAlternatives()),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
            self::KEY_DESCRIPTION => $model->getDescription(),
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
