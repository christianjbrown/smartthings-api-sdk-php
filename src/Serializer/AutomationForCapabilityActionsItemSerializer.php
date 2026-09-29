<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;
use ChristianBrown\SmartThings\Model\DynamicListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\ListForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\SliderForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionBaseInterface;

use function array_filter;

final class AutomationForCapabilityActionsItemSerializer implements AutomationForCapabilityActionsItemSerializerInterface
{
    private DynamicListForAutomationActionSerializerInterface $dynamicListForAutomationActionSerializer;
    private ListForAutomationActionSerializerInterface $listForAutomationActionSerializer;
    private MultiArgCommandSerializerInterface $multiArgCommandSerializer;
    private NumberFieldForAutomationActionSerializerInterface $numberFieldForAutomationActionSerializer;
    private SliderForAutomationActionSerializerInterface $sliderForAutomationActionSerializer;
    private TextFieldForAutomationActionSerializerInterface $textFieldForAutomationActionSerializer;
    private VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer;

    public function __construct(SliderForAutomationActionSerializerInterface $sliderForAutomationActionSerializer, ListForAutomationActionSerializerInterface $listForAutomationActionSerializer, DynamicListForAutomationActionSerializerInterface $dynamicListForAutomationActionSerializer, TextFieldForAutomationActionSerializerInterface $textFieldForAutomationActionSerializer, NumberFieldForAutomationActionSerializerInterface $numberFieldForAutomationActionSerializer, MultiArgCommandSerializerInterface $multiArgCommandSerializer, VisibleConditionBaseSerializerInterface $visibleConditionBaseSerializer)
    {
        $this->sliderForAutomationActionSerializer = $sliderForAutomationActionSerializer;
        $this->listForAutomationActionSerializer = $listForAutomationActionSerializer;
        $this->dynamicListForAutomationActionSerializer = $dynamicListForAutomationActionSerializer;
        $this->textFieldForAutomationActionSerializer = $textFieldForAutomationActionSerializer;
        $this->numberFieldForAutomationActionSerializer = $numberFieldForAutomationActionSerializer;
        $this->multiArgCommandSerializer = $multiArgCommandSerializer;
        $this->visibleConditionBaseSerializer = $visibleConditionBaseSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(AutomationForCapabilityActionsItemInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_DESCRIPTION => $model->getDescription(),
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_SLIDER => $this->serializeOptionalSlider($model->getSlider()),
            self::KEY_LIST => $this->serializeOptionalList($model->getList()),
            self::KEY_DYNAMIC_LIST => $this->serializeOptionalDynamicList($model->getDynamicList()),
            self::KEY_TEXT_FIELD => $this->serializeOptionalTextField($model->getTextField()),
            self::KEY_NUMBER_FIELD => $this->serializeOptionalNumberField($model->getNumberField()),
            self::KEY_MULTI_ARG_COMMAND => $this->serializeOptionalMultiArgCommand($model->getMultiArgCommand()),
            self::KEY_EMPHASIS => $model->getEmphasis(),
            self::KEY_VISIBLE_CONDITION => $this->serializeOptionalVisibleCondition($model->getVisibleCondition()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalDynamicList(?DynamicListForAutomationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->dynamicListForAutomationActionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalList(?ListForAutomationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listForAutomationActionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalMultiArgCommand(?MultiArgCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->multiArgCommandSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalNumberField(?NumberFieldForAutomationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->numberFieldForAutomationActionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSlider(?SliderForAutomationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderForAutomationActionSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTextField(?TextFieldForAutomationActionInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->textFieldForAutomationActionSerializer->serialize($value);
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
