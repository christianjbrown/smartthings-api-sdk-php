<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemIdInterface;

use function array_filter;
use function array_map;

final class ExcludedActionItemIdSerializer implements ExcludedActionItemIdSerializerInterface
{
    private ExcludedActionItemIdExcludeItemSerializerInterface $excludedActionItemIdExcludeItemSerializer;

    public function __construct(ExcludedActionItemIdExcludeItemSerializerInterface $excludedActionItemIdExcludeItemSerializer)
    {
        $this->excludedActionItemIdExcludeItemSerializer = $excludedActionItemIdExcludeItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedActionItemIdInterface $model): array
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
     * @param array<int, ExcludedActionItemIdExcludeItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeExclude(array $values): array
    {
        return array_map(fn (ExcludedActionItemIdExcludeItemInterface $item): array => $this->excludedActionItemIdExcludeItemSerializer->serialize($item), $values);
    }
}
