<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\DescriptionItemInterface;
use ChristianBrown\SmartThings\Model\DescriptionsInAutomationInterface;

use function array_filter;
use function array_map;

final class DescriptionsInAutomationSerializer implements DescriptionsInAutomationSerializerInterface
{
    private DescriptionItemSerializerInterface $descriptionItemSerializer;

    public function __construct(DescriptionItemSerializerInterface $descriptionItemSerializer)
    {
        $this->descriptionItemSerializer = $descriptionItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(DescriptionsInAutomationInterface $model): array
    {
        $serialized = [
            self::KEY_CONDITIONS => $this->serializeConditions($model->getConditions()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, DescriptionItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DescriptionItemInterface $item): array => $this->descriptionItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, DescriptionItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (DescriptionItemInterface $item): array => $this->descriptionItemSerializer->serialize($item), $values);
    }
}
