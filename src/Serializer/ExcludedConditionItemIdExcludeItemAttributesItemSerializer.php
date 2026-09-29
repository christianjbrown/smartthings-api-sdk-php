<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ExcludedConditionItemIdExcludeItemAttributesItemInterface;

use function array_filter;

final class ExcludedConditionItemIdExcludeItemAttributesItemSerializer implements ExcludedConditionItemIdExcludeItemAttributesItemSerializerInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ExcludedConditionItemIdExcludeItemAttributesItemInterface $model): array
    {
        $serialized = [
            self::KEY_NAME => $model->getName(),
            self::KEY_EXCLUDED_VALUES => $model->getExcludedValues(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }
}
