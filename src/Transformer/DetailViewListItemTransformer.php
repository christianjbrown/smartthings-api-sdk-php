<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DetailViewListItem;
use ChristianBrown\SmartThings\Model\DetailViewListItemInterface;

use function is_array;
use function is_int;
use function is_string;

final class DetailViewListItemTransformer implements DetailViewListItemTransformerInterface
{
    private ListForDetailViewTransformerInterface $listForDetailViewTransformer;
    private MultiArgCommandTransformerInterface $multiArgCommandTransformer;
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
    private VisibleConditionForDetailViewTransformerInterface $visibleConditionForDetailViewTransformer;

    public function __construct(ToggleSwitchTransformerInterface $toggleSwitchTransformer, StandbyPowerSwitchTransformerInterface $standbyPowerSwitchTransformer, SwitchControlTransformerInterface $switchControlTransformer, SliderTypeTransformerInterface $sliderTypeTransformer, PushButtonTransformerInterface $pushButtonTransformer, TextButtonTransformerInterface $textButtonTransformer, PlayPauseTransformerInterface $playPauseTransformer, PlayStopTransformerInterface $playStopTransformer, ListForDetailViewTransformerInterface $listForDetailViewTransformer, TextFieldTransformerInterface $textFieldTransformer, NumberFieldTransformerInterface $numberFieldTransformer, StepperTransformerInterface $stepperTransformer, StateTransformerInterface $stateTransformer, MultiArgCommandTransformerInterface $multiArgCommandTransformer, VisibleConditionForDetailViewTransformerInterface $visibleConditionForDetailViewTransformer)
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
        $this->multiArgCommandTransformer = $multiArgCommandTransformer;
        $this->visibleConditionForDetailViewTransformer = $visibleConditionForDetailViewTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DetailViewListItemInterface
    {
        $model = new DetailViewListItem(self::requireCapability($data), self::requireLabel($data), self::requireDisplayType($data));

        self::applyVersion($model, $data);
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
        $this->applyMultiArgCommand($model, $data);
        self::applyComponent($model, $data);
        $this->applyVisibleCondition($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyComponent(DetailViewListItem $model, array $data): void
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
    private function applyList(DetailViewListItem $model, array $data): void
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
    private function applyMultiArgCommand(DetailViewListItem $model, array $data): void
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
    private function applyNumberField(DetailViewListItem $model, array $data): void
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
    private function applyPlayPause(DetailViewListItem $model, array $data): void
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
    private function applyPlayStop(DetailViewListItem $model, array $data): void
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
    private function applyPushButton(DetailViewListItem $model, array $data): void
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
    private function applySlider(DetailViewListItem $model, array $data): void
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
    private function applyStandbyPowerSwitch(DetailViewListItem $model, array $data): void
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
    private function applyState(DetailViewListItem $model, array $data): void
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
    private function applyStepper(DetailViewListItem $model, array $data): void
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
    private function applySwitch(DetailViewListItem $model, array $data): void
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
    private function applyTextButton(DetailViewListItem $model, array $data): void
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
    private function applyTextField(DetailViewListItem $model, array $data): void
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
    private function applyToggleSwitch(DetailViewListItem $model, array $data): void
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
    private static function applyVersion(DetailViewListItem $model, array $data): void
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
    private function applyVisibleCondition(DetailViewListItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITION])) {
            return;
        }
        $model->setVisibleCondition($this->visibleConditionForDetailViewTransformer->transform($data[self::KEY_VISIBLE_CONDITION]));
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
}
