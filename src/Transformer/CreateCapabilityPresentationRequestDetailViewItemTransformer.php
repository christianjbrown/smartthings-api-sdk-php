<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItem;
use ChristianBrown\SmartThings\Model\CreateCapabilityPresentationRequestDetailViewItemInterface;

use function is_array;
use function is_string;

final class CreateCapabilityPresentationRequestDetailViewItemTransformer implements CreateCapabilityPresentationRequestDetailViewItemTransformerInterface
{
    private ListForDetailViewTransformerInterface $listForDetailViewTransformer;
    private NumberFieldTransformerInterface $numberFieldTransformer;
    private PlayPauseTransformerInterface $playPauseTransformer;
    private PlayStopTransformerInterface $playStopTransformer;
    private PushButtonTransformerInterface $pushButtonTransformer;
    private SliderTypeTransformerInterface $sliderTypeTransformer;
    private StandbyPowerSwitchTransformerInterface $standbyPowerSwitchTransformer;
    private StateTransformerInterface $stateTransformer;
    private StepperTransformerInterface $stepperTransformer;
    private SwitchControlTransformerInterface $switchControlTransformer;
    private TextButtonTransformerInterface $textButtonTransformer;
    private TextFieldTransformerInterface $textFieldTransformer;
    private ToggleSwitchTransformerInterface $toggleSwitchTransformer;
    private VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer;

    public function __construct(ToggleSwitchTransformerInterface $toggleSwitchTransformer, StandbyPowerSwitchTransformerInterface $standbyPowerSwitchTransformer, SwitchControlTransformerInterface $switchControlTransformer, SliderTypeTransformerInterface $sliderTypeTransformer, PushButtonTransformerInterface $pushButtonTransformer, TextButtonTransformerInterface $textButtonTransformer, PlayPauseTransformerInterface $playPauseTransformer, PlayStopTransformerInterface $playStopTransformer, ListForDetailViewTransformerInterface $listForDetailViewTransformer, TextFieldTransformerInterface $textFieldTransformer, NumberFieldTransformerInterface $numberFieldTransformer, StepperTransformerInterface $stepperTransformer, StateTransformerInterface $stateTransformer, VisibleConditionBaseTransformerInterface $visibleConditionBaseTransformer)
    {
        $this->toggleSwitchTransformer = $toggleSwitchTransformer;
        $this->standbyPowerSwitchTransformer = $standbyPowerSwitchTransformer;
        $this->switchControlTransformer = $switchControlTransformer;
        $this->sliderTypeTransformer = $sliderTypeTransformer;
        $this->pushButtonTransformer = $pushButtonTransformer;
        $this->textButtonTransformer = $textButtonTransformer;
        $this->playPauseTransformer = $playPauseTransformer;
        $this->playStopTransformer = $playStopTransformer;
        $this->listForDetailViewTransformer = $listForDetailViewTransformer;
        $this->textFieldTransformer = $textFieldTransformer;
        $this->numberFieldTransformer = $numberFieldTransformer;
        $this->stepperTransformer = $stepperTransformer;
        $this->stateTransformer = $stateTransformer;
        $this->visibleConditionBaseTransformer = $visibleConditionBaseTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): CreateCapabilityPresentationRequestDetailViewItemInterface
    {
        $model = new CreateCapabilityPresentationRequestDetailViewItem(self::requireLabel($data), self::requireDisplayType($data));

        $this->applyToggleSwitch($model, $data);
        $this->applyStandbyPowerSwitch($model, $data);
        $this->applySwitch($model, $data);
        $this->applySlider($model, $data);
        $this->applyPushButton($model, $data);
        $this->applyTextButton($model, $data);
        $this->applyPlayPause($model, $data);
        $this->applyPlayStop($model, $data);
        $this->applyList($model, $data);
        $this->applyTextField($model, $data);
        $this->applyNumberField($model, $data);
        $this->applyStepper($model, $data);
        $this->applyState($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listForDetailViewTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNumberField(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        $model->setNumberField($this->numberFieldTransformer->transform($data[self::KEY_NUMBER_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPlayPause(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PLAY_PAUSE])) {
            return;
        }
        if (!is_array($data[self::KEY_PLAY_PAUSE])) {
            return;
        }
        $model->setPlayPause($this->playPauseTransformer->transform($data[self::KEY_PLAY_PAUSE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPlayStop(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PLAY_STOP])) {
            return;
        }
        if (!is_array($data[self::KEY_PLAY_STOP])) {
            return;
        }
        $model->setPlayStop($this->playStopTransformer->transform($data[self::KEY_PLAY_STOP]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPushButton(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        if (!is_array($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        $model->setPushButton($this->pushButtonTransformer->transform($data[self::KEY_PUSH_BUTTON]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderTypeTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStandbyPowerSwitch(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STANDBY_POWER_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_STANDBY_POWER_SWITCH])) {
            return;
        }
        $model->setStandbyPowerSwitch($this->standbyPowerSwitchTransformer->transform($data[self::KEY_STANDBY_POWER_SWITCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->stateTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStepper(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STEPPER])) {
            return;
        }
        if (!is_array($data[self::KEY_STEPPER])) {
            return;
        }
        $model->setStepper($this->stepperTransformer->transform($data[self::KEY_STEPPER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySwitch(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_SWITCH])) {
            return;
        }
        $model->setSwitch($this->switchControlTransformer->transform($data[self::KEY_SWITCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTextButton(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TEXT_BUTTON])) {
            return;
        }
        if (!is_array($data[self::KEY_TEXT_BUTTON])) {
            return;
        }
        $model->setTextButton($this->textButtonTransformer->transform($data[self::KEY_TEXT_BUTTON]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTextField(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        $model->setTextField($this->textFieldTransformer->transform($data[self::KEY_TEXT_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyToggleSwitch(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TOGGLE_SWITCH])) {
            return;
        }
        if (!is_array($data[self::KEY_TOGGLE_SWITCH])) {
            return;
        }
        $model->setToggleSwitch($this->toggleSwitchTransformer->transform($data[self::KEY_TOGGLE_SWITCH]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyVisibleCondition(CreateCapabilityPresentationRequestDetailViewItem $model, array $data): void
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
