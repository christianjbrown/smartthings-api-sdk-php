<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItem;
use ChristianBrown\SmartThings\Model\AutomationForCapabilityActionsItemInterface;

use function is_array;
use function is_bool;
use function is_string;
use function sprintf;

final class AutomationForCapabilityActionsItemTransformer implements AutomationForCapabilityActionsItemTransformerInterface
{
    private DynamicListForAutomationActionTransformerInterface $dynamicListForAutomationActionTransformer;
    private ListForAutomationActionTransformerInterface $listForAutomationActionTransformer;
    private MultiArgCommandTransformerInterface $multiArgCommandTransformer;
    private NumberFieldForAutomationActionTransformerInterface $numberFieldForAutomationActionTransformer;
    private SliderForAutomationActionTransformerInterface $sliderForAutomationActionTransformer;
    private TextFieldForAutomationActionTransformerInterface $textFieldForAutomationActionTransformer;
    private VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer;

    public function __construct(SliderForAutomationActionTransformerInterface $sliderForAutomationActionTransformer, ListForAutomationActionTransformerInterface $listForAutomationActionTransformer, DynamicListForAutomationActionTransformerInterface $dynamicListForAutomationActionTransformer, TextFieldForAutomationActionTransformerInterface $textFieldForAutomationActionTransformer, NumberFieldForAutomationActionTransformerInterface $numberFieldForAutomationActionTransformer, MultiArgCommandTransformerInterface $multiArgCommandTransformer, VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer)
    {
        $this->sliderForAutomationActionTransformer = $sliderForAutomationActionTransformer;
        $this->listForAutomationActionTransformer = $listForAutomationActionTransformer;
        $this->dynamicListForAutomationActionTransformer = $dynamicListForAutomationActionTransformer;
        $this->textFieldForAutomationActionTransformer = $textFieldForAutomationActionTransformer;
        $this->numberFieldForAutomationActionTransformer = $numberFieldForAutomationActionTransformer;
        $this->multiArgCommandTransformer = $multiArgCommandTransformer;
        $this->visibleConditionBaseTransformer = $visibleConditionBaseTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): AutomationForCapabilityActionsItemInterface
    {
        $model = new AutomationForCapabilityActionsItem(self::requireLabel($data), self::requireDisplayType($data));

        self::applyDescription($model, $data);
        $this->applySlider($model, $data);
        $this->applyList($model, $data);
        $this->applyDynamicList($model, $data);
        $this->applyTextField($model, $data);
        $this->applyNumberField($model, $data);
        $this->applyMultiArgCommand($model, $data);
        self::applyEmphasis($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyDescription(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyDynamicList(AutomationForCapabilityActionsItem $model, array $data): void
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
    private static function applyEmphasis(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyList(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyMultiArgCommand(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyNumberField(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applySlider(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyTextField(AutomationForCapabilityActionsItem $model, array $data): void
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
    private function applyVisibleCondition(AutomationForCapabilityActionsItem $model, array $data): void
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
    private static function requireDisplayType(array $data): string
    {
        if (empty($data[self::KEY_DISPLAY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DISPLAY_TYPE));
        }
        if (!is_string($data[self::KEY_DISPLAY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DISPLAY_TYPE));
        }

        return $data[self::KEY_DISPLAY_TYPE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }
}
