<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\EnumSliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;

use function array_filter;

final class AutomationForCapabilityConditionsItemSerializer implements AutomationForCapabilityConditionsItemSerializerInterface
{
    private DynamicListForAutomationConditionSerializerInterface $dynamicListForAutomationConditionSerializer;
    private EnumSliderForAutomationConditionSerializerInterface $enumSliderForAutomationConditionSerializer;
    private ListForAutomationConditionSerializerInterface $listForAutomationConditionSerializer;
    private NumberFieldForAutomationConditionSerializerInterface $numberFieldForAutomationConditionSerializer;
    private SliderForAutomationConditionSerializerInterface $sliderForAutomationConditionSerializer;
    private TextFieldForAutomationConditionSerializerInterface $textFieldForAutomationConditionSerializer;
    private VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer;

    public function __construct(SliderForAutomationConditionSerializerInterface $sliderForAutomationConditionSerializer, ListForAutomationConditionSerializerInterface $listForAutomationConditionSerializer, DynamicListForAutomationConditionSerializerInterface $dynamicListForAutomationConditionSerializer, NumberFieldForAutomationConditionSerializerInterface $numberFieldForAutomationConditionSerializer, TextFieldForAutomationConditionSerializerInterface $textFieldForAutomationConditionSerializer, EnumSliderForAutomationConditionSerializerInterface $enumSliderForAutomationConditionSerializer, VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer)
    {
        $this->sliderForAutomationConditionSerializer = $sliderForAutomationConditionSerializer;
        $this->listForAutomationConditionSerializer = $listForAutomationConditionSerializer;
        $this->dynamicListForAutomationConditionSerializer = $dynamicListForAutomationConditionSerializer;
        $this->numberFieldForAutomationConditionSerializer = $numberFieldForAutomationConditionSerializer;
        $this->textFieldForAutomationConditionSerializer = $textFieldForAutomationConditionSerializer;
        $this->enumSliderForAutomationConditionSerializer = $enumSliderForAutomationConditionSerializer;
        $this->visibleConditionBaseSerializer = $visibleConditionBaseSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(AutomationForCapabilityConditionsItemInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_DESCRIPTION => $model->getDescription(),
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_SLIDER => $this->serializeOptionalSlider($model->getSlider()),
            self::KEY_LIST => $this->serializeOptionalList($model->getList()),
            self::KEY_DYNAMIC_LIST => $this->serializeOptionalDynamicList($model->getDynamicList()),
            self::KEY_NUMBER_FIELD => $this->serializeOptionalNumberField($model->getNumberField()),
            self::KEY_TEXT_FIELD => $this->serializeOptionalTextField($model->getTextField()),
            self::KEY_ENUM_SLIDER => $this->serializeOptionalEnumSlider($model->getEnumSlider()),
            self::KEY_EMPHASIS => $model->getEmphasis(),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDynamicList(?DynamicListForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->dynamicListForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalEnumSlider(?EnumSliderForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->enumSliderForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalList(?ListForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalNumberField(?NumberFieldForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->numberFieldForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSlider(?SliderForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTextField(?TextFieldForAutomationConditionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->textFieldForAutomationConditionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalVisibleCondition(?VisibleConditionBaseInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->visibleConditionBaseSerializer->serialize($value);
    }
}
