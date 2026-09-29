<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdInterface;

use function array_filter;
use function array_map;

final class ExcludedConditionItemIdSerializer implements ExcludedConditionItemIdSerializerInterface
{
    private ExcludedConditionItemIdExcludeItemSerializerInterface $excludedConditionItemIdExcludeItemSerializer;

    public function __construct(ExcludedConditionItemIdExcludeItemSerializerInterface $excludedConditionItemIdExcludeItemSerializer)
    {
        $this->excludedConditionItemIdExcludeItemSerializer = $excludedConditionItemIdExcludeItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedConditionItemIdInterface $model): array
    {
        $serialized = [
            self::KEY_ID => $model->getId(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_EXCLUDE => $this->serializeExclude($model->getExclude()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, ExcludedConditionItemIdExcludeItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeExclude(array $values): array
    {
        return array_map(fn (ExcludedConditionItemIdExcludeItemInterface $item): array => $this->excludedConditionItemIdExcludeItemSerializer->serialize($item), $values);
    }
}
