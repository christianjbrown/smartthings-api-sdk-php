<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;

use function array_filter;
use function array_map;

final class DynamicListForAutomationActionSerializer implements DynamicListForAutomationActionSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;
    private SupportedValuesForDynamicListSerializerInterface $supportedValuesForDynamicListSerializer;

    public function __construct(SupportedValuesForDynamicListSerializerInterface $supportedValuesForDynamicListSerializer, AlternativeItemSerializerInterface $alternativeItemSerializer)
    {
        $this->supportedValuesForDynamicListSerializer = $supportedValuesForDynamicListSerializer;
        $this->alternativeItemSerializer = $alternativeItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DynamicListForAutomationActionInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENT_TYPE => $model->getArgumentType(),
            self::KEY_SUPPORTED_VALUES => $this->serializeOptionalSupportedValuesForDynamicList($model->getSupportedValues()),
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

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSupportedValuesForDynamicList(?SupportedValuesForDynamicListInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->supportedValuesForDynamicListSerializer->serialize($value);
    }
}
