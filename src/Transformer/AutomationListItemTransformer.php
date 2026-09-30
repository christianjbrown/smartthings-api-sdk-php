<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AutomationListItem;
use ChristianBrown\SmartThings\Model\AutomationListItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedConditionItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class AutomationListItemTransformer implements AutomationListItemTransformerInterface
{
    private DynamicListForAutomationConditionTransformerInterface $dynamicListForAutomationConditionTransformer;
    private EnumSliderForAutomationConditionTransformerInterface $enumSliderForAutomationConditionTransformer;
    private ExcludedConditionItemTransformerInterface $excludedConditionItemTransformer;
    private ListForAutomationConditionTransformerInterface $listForAutomationConditionTransformer;
    private NumberFieldForAutomationConditionTransformerInterface $numberFieldForAutomationConditionTransformer;
    private SliderForAutomationConditionTransformerInterface $sliderForAutomationConditionTransformer;
    private TextFieldForAutomationConditionTransformerInterface $textFieldForAutomationConditionTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(SliderForAutomationConditionTransformerInterface $sliderForAutomationConditionTransformer, ListForAutomationConditionTransformerInterface $listForAutomationConditionTransformer, DynamicListForAutomationConditionTransformerInterface $dynamicListForAutomationConditionTransformer, NumberFieldForAutomationConditionTransformerInterface $numberFieldForAutomationConditionTransformer, TextFieldForAutomationConditionTransformerInterface $textFieldForAutomationConditionTransformer, EnumSliderForAutomationConditionTransformerInterface $enumSliderForAutomationConditionTransformer, ExcludedConditionItemTransformerInterface $excludedConditionItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->sliderForAutomationConditionTransformer = $sliderForAutomationConditionTransformer;
        $this->listForAutomationConditionTransformer = $listForAutomationConditionTransformer;
        $this->dynamicListForAutomationConditionTransformer = $dynamicListForAutomationConditionTransformer;
        $this->numberFieldForAutomationConditionTransformer = $numberFieldForAutomationConditionTransformer;
        $this->textFieldForAutomationConditionTransformer = $textFieldForAutomationConditionTransformer;
        $this->enumSliderForAutomationConditionTransformer = $enumSliderForAutomationConditionTransformer;
        $this->excludedConditionItemTransformer = $excludedConditionItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationListItemInterface
    {
        $model = new AutomationListItem(self::requireCapability($data), self::requireLabel($data), self::requireDisplayType($data));

        self::applyVersion($model, $data);
        self::applyDescription($model, $data);
        $this->applySlider($model, $data);
        $this->applyList($model, $data);
        $this->applyDynamicList($model, $data);
        $this->applyNumberField($model, $data);
        $this->applyTextField($model, $data);
        $this->applyEnumSlider($model, $data);
        self::applyEmphasis($model, $data);
        $this->applyExclusion($model, $data);
        self::applyComponent($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(AutomationListItem $model, array $data): void
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return;
        }
        $model->setComponent($data[self::KEY_COMPONENT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AutomationListItem $model, array $data): void
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
    private function applyDynamicList(AutomationListItem $model, array $data): void
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
    private static function applyEmphasis(AutomationListItem $model, array $data): void
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
    private function applyEnumSlider(AutomationListItem $model, array $data): void
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
    private function applyExclusion(AutomationListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EXCLUSION])) {
            return;
        }
        if (!is_array($data[self::KEY_EXCLUSION])) {
            return;
        }
        $model->setExclusion($this->transformListExcludedConditionItem($data[self::KEY_EXCLUSION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(AutomationListItem $model, array $data): void
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
    private function applyNumberField(AutomationListItem $model, array $data): void
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
    private function applySlider(AutomationListItem $model, array $data): void
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
    private function applyTextField(AutomationListItem $model, array $data): void
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
    private static function applyVersion(AutomationListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VERSION])) {
            return;
        }
        if (!is_int($data[self::KEY_VERSION])) {
            return;
        }
        $model->setVersion($data[self::KEY_VERSION]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(AutomationListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireCapability(array $data): ?string
    {
        if (empty($data[self::KEY_CAPABILITY])) {
            return null;
        }
        if (!is_string($data[self::KEY_CAPABILITY])) {
            return null;
        }

        return $data[self::KEY_CAPABILITY];
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

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExcludedConditionItemInterface>
     */
    private function transformListExcludedConditionItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedConditionItemInterface => $this->excludedConditionItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
