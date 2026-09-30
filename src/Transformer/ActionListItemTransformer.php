<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionListItem;
use ChristianBrown\SmartThings\Model\ActionListItemInterface;
use ChristianBrown\SmartThings\Model\ExcludedActionItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class ActionListItemTransformer implements ActionListItemTransformerInterface
{
    private DynamicListForAutomationActionTransformerInterface $dynamicListForAutomationActionTransformer;
    private ExcludedActionItemTransformerInterface $excludedActionItemTransformer;
    private ListForAutomationActionTransformerInterface $listForAutomationActionTransformer;
    private MultiArgCommandTransformerInterface $multiArgCommandTransformer;
    private NumberFieldForAutomationActionTransformerInterface $numberFieldForAutomationActionTransformer;
    private SliderForAutomationActionTransformerInterface $sliderForAutomationActionTransformer;
    private TextFieldForAutomationActionTransformerInterface $textFieldForAutomationActionTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(SliderForAutomationActionTransformerInterface $sliderForAutomationActionTransformer, ListForAutomationActionTransformerInterface $listForAutomationActionTransformer, DynamicListForAutomationActionTransformerInterface $dynamicListForAutomationActionTransformer, TextFieldForAutomationActionTransformerInterface $textFieldForAutomationActionTransformer, NumberFieldForAutomationActionTransformerInterface $numberFieldForAutomationActionTransformer, MultiArgCommandTransformerInterface $multiArgCommandTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer, ExcludedActionItemTransformerInterface $excludedActionItemTransformer)
    {
        $this->sliderForAutomationActionTransformer = $sliderForAutomationActionTransformer;
        $this->listForAutomationActionTransformer = $listForAutomationActionTransformer;
        $this->dynamicListForAutomationActionTransformer = $dynamicListForAutomationActionTransformer;
        $this->textFieldForAutomationActionTransformer = $textFieldForAutomationActionTransformer;
        $this->numberFieldForAutomationActionTransformer = $numberFieldForAutomationActionTransformer;
        $this->multiArgCommandTransformer = $multiArgCommandTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
        $this->excludedActionItemTransformer = $excludedActionItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionListItemInterface
    {
        $model = new ActionListItem(self::requireCapability($data), self::requireLabel($data), self::requireDisplayType($data));

        self::applyVersion($model, $data);
        self::applyDescription($model, $data);
        $this->applySlider($model, $data);
        $this->applyList($model, $data);
        $this->applyDynamicList($model, $data);
        $this->applyTextField($model, $data);
        $this->applyNumberField($model, $data);
        $this->applyMultiArgCommand($model, $data);
        self::applyEmphasis($model, $data);
        self::applyComponent($model, $data);
        $this->applyVisibleCondition($model, $data);
        $this->applyExclusion($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(ActionListItem $model, array $data): void
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
    private static function applyDescription(ActionListItem $model, array $data): void
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
    private function applyDynamicList(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_DYNAMIC_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_DYNAMIC_LIST])) {
            return;
        }
        $model->setDynamicList($this->dynamicListForAutomationActionTransformer->transform($data[self::KEY_DYNAMIC_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyEmphasis(ActionListItem $model, array $data): void
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
    private function applyExclusion(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EXCLUSION])) {
            return;
        }
        if (!is_array($data[self::KEY_EXCLUSION])) {
            return;
        }
        $model->setExclusion($this->transformListExcludedActionItem($data[self::KEY_EXCLUSION]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listForAutomationActionTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyMultiArgCommand(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_MULTI_ARG_COMMAND])) {
            return;
        }
        if (!is_array($data[self::KEY_MULTI_ARG_COMMAND])) {
            return;
        }
        $model->setMultiArgCommand($this->multiArgCommandTransformer->transform($data[self::KEY_MULTI_ARG_COMMAND]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNumberField(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        $model->setNumberField($this->numberFieldForAutomationActionTransformer->transform($data[self::KEY_NUMBER_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderForAutomationActionTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTextField(ActionListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        $model->setTextField($this->textFieldForAutomationActionTransformer->transform($data[self::KEY_TEXT_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(ActionListItem $model, array $data): void
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
    private function applyVisibleCondition(ActionListItem $model, array $data): void
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
     * @return array<int, ExcludedActionItemInterface>
     */
    private function transformListExcludedActionItem(array $data): array
    {
        return array_values(array_map(fn (array $item): ExcludedActionItemInterface => $this->excludedActionItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
