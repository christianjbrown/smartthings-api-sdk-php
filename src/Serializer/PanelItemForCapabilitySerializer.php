<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\EmptyWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;
use ChristianBrown\SmartThings\Model\PushButtonWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\SliderWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StateWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\StepperWithAvailableSizeInterface;

use function array_filter;

final class PanelItemForCapabilitySerializer implements PanelItemForCapabilitySerializerInterface
{
    private EmptyWithAvailableSizeSerializerInterface $emptyWithAvailableSizeSerializer;
    private ListWithAvailableSizeSerializerInterface $listWithAvailableSizeSerializer;
    private PushButtonWithAvailableSizeSerializerInterface $pushButtonWithAvailableSizeSerializer;
    private SliderWithAvailableSizeSerializerInterface $sliderWithAvailableSizeSerializer;
    private StateWithAvailableSizeSerializerInterface $stateWithAvailableSizeSerializer;
    private StepperWithAvailableSizeSerializerInterface $stepperWithAvailableSizeSerializer;

    public function __construct(StepperWithAvailableSizeSerializerInterface $stepperWithAvailableSizeSerializer, ListWithAvailableSizeSerializerInterface $listWithAvailableSizeSerializer, PushButtonWithAvailableSizeSerializerInterface $pushButtonWithAvailableSizeSerializer, StateWithAvailableSizeSerializerInterface $stateWithAvailableSizeSerializer, SliderWithAvailableSizeSerializerInterface $sliderWithAvailableSizeSerializer, EmptyWithAvailableSizeSerializerInterface $emptyWithAvailableSizeSerializer)
    {
        $this->stepperWithAvailableSizeSerializer = $stepperWithAvailableSizeSerializer;
        $this->listWithAvailableSizeSerializer = $listWithAvailableSizeSerializer;
        $this->pushButtonWithAvailableSizeSerializer = $pushButtonWithAvailableSizeSerializer;
        $this->stateWithAvailableSizeSerializer = $stateWithAvailableSizeSerializer;
        $this->sliderWithAvailableSizeSerializer = $sliderWithAvailableSizeSerializer;
        $this->emptyWithAvailableSizeSerializer = $emptyWithAvailableSizeSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(PanelItemForCapabilityInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_STEPPER => $this->serializeOptionalStepper($model->getStepper()),
            self::KEY_LIST => $this->serializeOptionalList($model->getList()),
            self::KEY_PUSH_BUTTON => $this->serializeOptionalPushButton($model->getPushButton()),
            self::KEY_STATE => $this->serializeOptionalState($model->getState()),
            self::KEY_SLIDER => $this->serializeOptionalSlider($model->getSlider()),
            self::KEY_EMPTY => $this->serializeOptionalEmpty($model->getEmpty()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalEmpty(?EmptyWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->emptyWithAvailableSizeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalList(?ListWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listWithAvailableSizeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalPushButton(?PushButtonWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->pushButtonWithAvailableSizeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSlider(?SliderWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderWithAvailableSizeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalState(?StateWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stateWithAvailableSizeSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalStepper(?StepperWithAvailableSizeInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->stepperWithAvailableSizeSerializer->serialize($value);
    }
}
