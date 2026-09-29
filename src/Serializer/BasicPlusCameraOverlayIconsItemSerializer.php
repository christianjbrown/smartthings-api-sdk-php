<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;

final class BasicPlusCameraOverlayIconsItemSerializer implements BasicPlusCameraOverlayIconsItemSerializerInterface
{
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraOverlayIconsItemInterface $model): array
    {
        $serialized = [
            self::KEY_ICON_URL => $model->getIconUrl(),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionSerializer->serialize($value);
    }
}
