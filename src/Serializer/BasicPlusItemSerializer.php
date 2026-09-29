<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\BasicPlusCameraInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;
use ChristianBrown\SmartThings\Model\PanelForDeviceConfigInterface;

use function array_filter;
use function array_map;

final class BasicPlusItemSerializer implements BasicPlusItemSerializerInterface
{
    private BasicPlusCameraSerializerInterface $basicPlusCameraSerializer;
    private BasicPlusItemActionsItemSerializerInterface $basicPlusItemActionsItemSerializer;
    private BasicPlusItemProgressBarsItemSerializerInterface $basicPlusItemProgressBarsItemSerializer;
    private BasicPlusLightSerializerInterface $basicPlusLightSerializer;
    private BasicPlusStateBoardItemSerializerInterface $basicPlusStateBoardItemSerializer;
    private BasicPlusTvSerializerInterface $basicPlusTvSerializer;
    private PanelForDeviceConfigSerializerInterface $panelForDeviceConfigSerializer;

    public function __construct(BasicPlusCameraSerializerInterface $basicPlusCameraSerializer, BasicPlusTvSerializerInterface $basicPlusTvSerializer, BasicPlusLightSerializerInterface $basicPlusLightSerializer, BasicPlusItemActionsItemSerializerInterface $basicPlusItemActionsItemSerializer, BasicPlusStateBoardItemSerializerInterface $basicPlusStateBoardItemSerializer, BasicPlusItemProgressBarsItemSerializerInterface $basicPlusItemProgressBarsItemSerializer, PanelForDeviceConfigSerializerInterface $panelForDeviceConfigSerializer)
    {
        $this->basicPlusCameraSerializer = $basicPlusCameraSerializer;
        $this->basicPlusTvSerializer = $basicPlusTvSerializer;
        $this->basicPlusLightSerializer = $basicPlusLightSerializer;
        $this->basicPlusItemActionsItemSerializer = $basicPlusItemActionsItemSerializer;
        $this->basicPlusStateBoardItemSerializer = $basicPlusStateBoardItemSerializer;
        $this->basicPlusItemProgressBarsItemSerializer = $basicPlusItemProgressBarsItemSerializer;
        $this->panelForDeviceConfigSerializer = $panelForDeviceConfigSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(BasicPlusItemInterface $model): array
    {
        $serialized = [
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_CAMERA => $this->serializeOptionalCamera($model->getCamera()),
            self::KEY_TV => $this->serializeOptionalTv($model->getTv()),
            self::KEY_LIGHT => $this->serializeOptionalLight($model->getLight()),
            self::KEY_ACTIONS => $this->serializeActions($model->getActions()),
            self::KEY_STATE_BOARD => $this->serializeStateBoard($model->getStateBoard()),
            self::KEY_PROGRESS_BARS => $this->serializeProgressBars($model->getProgressBars()),
            self::KEY_PANEL => $this->serializeOptionalPanel($model->getPanel()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param null|array<int, BasicPlusItemActionsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeActions(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusItemActionsItemInterface $item): array => $this->basicPlusItemActionsItemSerializer->serialize($item), $values);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalCamera(?BasicPlusCameraInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusCameraSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalLight(?BasicPlusLightInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusLightSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPanel(?PanelForDeviceConfigInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->panelForDeviceConfigSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTv(?BasicPlusTvInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->basicPlusTvSerializer->serialize($value);
    }

    /**
     * @param null|array<int, BasicPlusItemProgressBarsItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeProgressBars(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusItemProgressBarsItemInterface $item): array => $this->basicPlusItemProgressBarsItemSerializer->serialize($item), $values);
    }

    /**
     * @param null|array<int, BasicPlusStateBoardItemInterface> $values
     *
     * @return null|array<int, mixed[]>
     */
    private function serializeStateBoard(?array $values): ?array
    {
        if (null === $values) {
            return null;
        }

        return array_map(fn (BasicPlusStateBoardItemInterface $item): array => $this->basicPlusStateBoardItemSerializer->serialize($item), $values);
    }
}
