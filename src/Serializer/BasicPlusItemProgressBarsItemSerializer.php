<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsBarItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class BasicPlusItemProgressBarsItemSerializer implements BasicPlusItemProgressBarsItemSerializerInterface
{
    private BasicPlusProgressBarsBarItemSerializerInterface $basicPlusProgressBarsBarItemSerializer;
    private BasicPlusProgressBarsStateItemSerializerInterface $basicPlusProgressBarsStateItemSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(BasicPlusProgressBarsStateItemSerializerInterface $basicPlusProgressBarsStateItemSerializer, BasicPlusProgressBarsBarItemSerializerInterface $basicPlusProgressBarsBarItemSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->basicPlusProgressBarsStateItemSerializer = $basicPlusProgressBarsStateItemSerializer;
        $this->basicPlusProgressBarsBarItemSerializer = $basicPlusProgressBarsBarItemSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusItemProgressBarsItemInterface $model): array
    {
        $serialized = [
            self::KEY_HEADERS => $this->serializeHeaders($model->getHeaders()),
            self::KEY_BAR => $this->serializeOptionalBar($model->getBar()),
            self::KEY_FOOTERS => $this->serializeFooters($model->getFooters()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeFooters(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusProgressBarsStateItemInterface $item): array => $this->basicPlusProgressBarsStateItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, BasicPlusProgressBarsStateItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeHeaders(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusProgressBarsStateItemInterface $item): array => $this->basicPlusProgressBarsStateItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalBar(?BasicPlusProgressBarsBarItemInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusProgressBarsBarItemSerializer->serialize($value);
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
