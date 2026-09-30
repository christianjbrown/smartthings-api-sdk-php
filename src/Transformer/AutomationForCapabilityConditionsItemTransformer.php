<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItem;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityConditionsItemInterface;

use function is_array;
use function is_bool;
use function is_string;

final class AutomationForCapabilityConditionsItemTransformer implements AutomationForCapabilityConditionsItemTransformerInterface
{
    private DynamicListForAutomationConditionTransformerInterface $dynamicListForAutomationConditionTransformer;
    private EnumSliderForAutomationConditionTransformerInterface $enumSliderForAutomationConditionTransformer;
    private ListForAutomationConditionTransformerInterface $listForAutomationConditionTransformer;
    private NumberFieldForAutomationConditionTransformerInterface $numberFieldForAutomationConditionTransformer;
    private SliderForAutomationConditionTransformerInterface $sliderForAutomationConditionTransformer;
    private TextFieldForAutomationConditionTransformerInterface $textFieldForAutomationConditionTransformer;
    private VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer;

    public function __construct(SliderForAutomationConditionTransformerInterface $sliderForAutomationConditionTransformer, ListForAutomationConditionTransformerInterface $listForAutomationConditionTransformer, DynamicListForAutomationConditionTransformerInterface $dynamicListForAutomationConditionTransformer, NumberFieldForAutomationConditionTransformerInterface $numberFieldForAutomationConditionTransformer, TextFieldForAutomationConditionTransformerInterface $textFieldForAutomationConditionTransformer, EnumSliderForAutomationConditionTransformerInterface $enumSliderForAutomationConditionTransformer, VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer)
    {
        $this->sliderForAutomationConditionTransformer = $sliderForAutomationConditionTransformer;
        $this->listForAutomationConditionTransformer = $listForAutomationConditionTransformer;
        $this->dynamicListForAutomationConditionTransformer = $dynamicListForAutomationConditionTransformer;
        $this->numberFieldForAutomationConditionTransformer = $numberFieldForAutomationConditionTransformer;
        $this->textFieldForAutomationConditionTransformer = $textFieldForAutomationConditionTransformer;
        $this->enumSliderForAutomationConditionTransformer = $enumSliderForAutomationConditionTransformer;
        $this->visibleConditionBaseTransformer = $visibleConditionBaseTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationForCapabilityConditionsItemInterface
    {
        $model = new AutomationForCapabilityConditionsItem(self::requireLabel($data), self::requireDisplayType($data));

        self::applyDescription($model, $data);
        $this->applySlider($model, $data);
        $this->applyList($model, $data);
        $this->applyDynamicList($model, $data);
        $this->applyNumberField($model, $data);
        $this->applyTextField($model, $data);
        $this->applyEnumSlider($model, $data);
        self::applyEmphasis($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (empty($data[self::KEY_DESCRIPTION])) {
            return;
        }
        if (!is_string($data[self::KEY_DESCRIPTION])) {
            return;
        }
        $model->setDescription($data[self::KEY_DESCRIPTION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDynamicList(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_DYNAMIC_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_DYNAMIC_LIST])) {
            return;
        }
        $model->setDynamicList($this->dynamicListForAutomationConditionTransformer->transform($data[self::KEY_DYNAMIC_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmphasis(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EMPHASIS])) {
            return;
        }
        if (!is_bool($data[self::KEY_EMPHASIS])) {
            return;
        }
        $model->setEmphasis($data[self::KEY_EMPHASIS]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEnumSlider(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ENUM_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_ENUM_SLIDER])) {
            return;
        }
        $model->setEnumSlider($this->enumSliderForAutomationConditionTransformer->transform($data[self::KEY_ENUM_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listForAutomationConditionTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNumberField(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        $model->setNumberField($this->numberFieldForAutomationConditionTransformer->transform($data[self::KEY_NUMBER_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderForAutomationConditionTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTextField(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        $model->setTextField($this->textFieldForAutomationConditionTransformer->transform($data[self::KEY_TEXT_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(AutomationForCapabilityConditionsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionBaseTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDisplayType(array $data): ?string
    {
        if (empty($data[self::KEY_DISPLAY_TYPE])) {
            return null;
        }
        if (!is_string($data[self::KEY_DISPLAY_TYPE])) {
            return null;
        }

        return $data[self::KEY_DISPLAY_TYPE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): ?string
    {
        if (empty($data[self::KEY_LABEL])) {
            return null;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return null;
        }

        return $data[self::KEY_LABEL];
    }
}
