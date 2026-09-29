<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedActionItemIdExcludeItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;

use function array_filter;
use function array_map;

final class ExcludedActionItemIdExcludeItemSerializer implements ExcludedActionItemIdExcludeItemSerializerInterface
{
    private ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface $excludedConditionItemIdExcludeItemAttributesItemSerializer;

    public function __construct(ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface $excludedConditionItemIdExcludeItemAttributesItemSerializer)
    {
        $this->excludedConditionItemIdExcludeItemAttributesItemSerializer = $excludedConditionItemIdExcludeItemAttributesItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ExcludedActionItemIdExcludeItemInterface $model): array
    {
        $serialized = [
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMMANDS => $this->serializeCommands($model->getCommands()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeCommands(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (ExcludedConditionItemIdExcludeItemAttributesItemInterface $item): array => $this->excludedConditionItemIdExcludeItemAttributesItemSerializer->serialize($item), $values);
    }
}
