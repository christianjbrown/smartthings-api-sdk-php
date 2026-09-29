<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class BasicPlusStateBoardItemSerializer implements BasicPlusStateBoardItemSerializerInterface
{
    private AlternativeItemSerializerInterface $alternativeItemSerializer;
    private BasicPlusStateBoardColorsSerializerInterface $basicPlusStateBoardColorsSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(AlternativeItemSerializerInterface $alternativeItemSerializer, BasicPlusStateBoardColorsSerializerInterface $basicPlusStateBoardColorsSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->alternativeItemSerializer = $alternativeItemSerializer;
        $this->basicPlusStateBoardColorsSerializer = $basicPlusStateBoardColorsSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusStateBoardItemInterface $model): array
    {
        $serialized = [
            self::KEY_CAPABILITY => $model->getCapability(),
            self::KEY_VERSION => $model->getVersion(),
            self::KEY_COMPONENT => $model->getComponent(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_TYPE => $model->getValueType(),
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_UNIT => $model->getUnit(),
            self::KEY_ALTERNATIVES => $this->serializeAlternatives($model->getAlternatives()),
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_COLORS => $this->serializeColors($model->getColors()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
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
     * @param null|array<int, BasicPlusStateBoardColorsInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeColors(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusStateBoardColorsInterface $item): array => $this->basicPlusStateBoardColorsSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, VisibleConditionInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeVisibleConditions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (VisibleConditionInterface $item): array => $this->visibleConditionSerializer->serialize($item), $values);
    }
}
