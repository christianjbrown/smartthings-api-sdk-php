<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;

use function array_filter;
use function array_map;

final class BasicPlusStateBoardColorsSerializer implements BasicPlusStateBoardColorsSerializerInterface
{
    private VisibleConditionForColorItemSerializerInterface $visibleConditionForColorItemSerializer;

    public function __construct(VisibleConditionForColorItemSerializerInterface $visibleConditionForColorItemSerializer)
    {
        $this->visibleConditionForColorItemSerializer = $visibleConditionForColorItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusStateBoardColorsInterface $model): array
    {
        $serialized = [
            self::KEY_COLOR => $model->getColor(),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, VisibleConditionForColorItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeVisibleConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (VisibleConditionForColorItemInterface $item): array => $this->visibleConditionForColorItemSerializer->serialize($item), $values);
    }
}
