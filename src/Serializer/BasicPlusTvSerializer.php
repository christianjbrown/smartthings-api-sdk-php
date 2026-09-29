<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusTvChannelInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvDirectionalPadInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvVolumeInterface;
use ChristianBrown\SmartThings\Model\ButtonForTvInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;

final class BasicPlusTvSerializer implements BasicPlusTvSerializerInterface
{
    private BasicPlusTvChannelSerializerInterface $basicPlusTvChannelSerializer;
    private BasicPlusTvDirectionalPadSerializerInterface $basicPlusTvDirectionalPadSerializer;
    private BasicPlusTvVolumeSerializerInterface $basicPlusTvVolumeSerializer;
    private ButtonForTvSerializerInterface $buttonForTvSerializer;
    private VisibleConditionSerializerInterface $visibleConditionSerializer;

    public function __construct(BasicPlusTvVolumeSerializerInterface $basicPlusTvVolumeSerializer, ButtonForTvSerializerInterface $buttonForTvSerializer, BasicPlusTvChannelSerializerInterface $basicPlusTvChannelSerializer, BasicPlusTvDirectionalPadSerializerInterface $basicPlusTvDirectionalPadSerializer, VisibleConditionSerializerInterface $visibleConditionSerializer)
    {
        $this->basicPlusTvVolumeSerializer = $basicPlusTvVolumeSerializer;
        $this->buttonForTvSerializer = $buttonForTvSerializer;
        $this->basicPlusTvChannelSerializer = $basicPlusTvChannelSerializer;
        $this->basicPlusTvDirectionalPadSerializer = $basicPlusTvDirectionalPadSerializer;
        $this->visibleConditionSerializer = $visibleConditionSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusTvInterface $model): array
    {
        $serialized = [
            self::KEY_VOLUME => $this->serializeOptionalVolume($model->getVolume()),
            self::KEY_BUTTONS => $this->serializeButtons($model->getButtons()),
            self::KEY_CHANNEL => $this->serializeOptionalChannel($model->getChannel()),
            self::KEY_DIRECTIONAL_PAD => $this->serializeOptionalDirectionalPad($model->getDirectionalPad()),
            self::KEY_OPERATOR => $model->getOperator(),
            self::KEY_VISIBLE_CONDITIONS => $this->serializeVisibleConditions($model->getVisibleConditions()),
            self::KEY_HIDE_DASHBOARD_ACTIONS => $model->getHideDashboardActions(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, ButtonForTvInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeButtons(array $values): array
    {
        return array_map(fn (ButtonForTvInterface $item): array => $this->buttonForTvSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalChannel(?BasicPlusTvChannelInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusTvChannelSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDirectionalPad(?BasicPlusTvDirectionalPadInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusTvDirectionalPadSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVolume(?BasicPlusTvVolumeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusTvVolumeSerializer->serialize($value);
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
