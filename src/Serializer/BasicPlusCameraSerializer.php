<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraImageInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;
use ChristianBrown\SmartThings\Model\BasicPlusCameraOverlayIconsItemInterface;

use function array_filter;
use function array_map;

final class BasicPlusCameraSerializer implements BasicPlusCameraSerializerInterface
{
    private BasicPlusCameraImageSerializerInterface $basicPlusCameraImageSerializer;
    private BasicPlusCameraOverlayIconsItemSerializerInterface $basicPlusCameraOverlayIconsItemSerializer;

    public function __construct(BasicPlusCameraImageSerializerInterface $basicPlusCameraImageSerializer, BasicPlusCameraOverlayIconsItemSerializerInterface $basicPlusCameraOverlayIconsItemSerializer)
    {
        $this->basicPlusCameraImageSerializer = $basicPlusCameraImageSerializer;
        $this->basicPlusCameraOverlayIconsItemSerializer = $basicPlusCameraOverlayIconsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusCameraInterface $model): array
    {
        $serialized = [
            self::KEY_IMAGE => $this->serializeOptionalBasicPlusCameraImage($model->getImage()),
            self::KEY_OVERLAY_ICONS => $this->serializeOverlayIcons($model->getOverlayIcons()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalBasicPlusCameraImage(?BasicPlusCameraImageInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusCameraImageSerializer->serialize($value);
    }

    /**
     * @param null|array<int, BasicPlusCameraOverlayIconsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeOverlayIcons(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusCameraOverlayIconsItemInterface $item): array => $this->basicPlusCameraOverlayIconsItemSerializer->serialize($item), $values);
    }
}
