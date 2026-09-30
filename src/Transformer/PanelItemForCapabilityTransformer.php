<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelItemForCapability;
use ChristianBrown\SmartThings\Model\PanelItemForCapabilityInterface;

use function is_array;
use function is_string;

final class PanelItemForCapabilityTransformer implements PanelItemForCapabilityTransformerInterface
{
    private EmptyWithAvailableSizeTransformerInterface $emptyWithAvailableSizeTransformer;
    private ListWithAvailableSizeTransformerInterface $listWithAvailableSizeTransformer;
    private PushButtonWithAvailableSizeTransformerInterface $pushButtonWithAvailableSizeTransformer;
    private SliderWithAvailableSizeTransformerInterface $sliderWithAvailableSizeTransformer;
    private StateWithAvailableSizeTransformerInterface $stateWithAvailableSizeTransformer;
    private StepperWithAvailableSizeTransformerInterface $stepperWithAvailableSizeTransformer;

    public function __construct(StepperWithAvailableSizeTransformerInterface $stepperWithAvailableSizeTransformer, ListWithAvailableSizeTransformerInterface $listWithAvailableSizeTransformer, PushButtonWithAvailableSizeTransformerInterface $pushButtonWithAvailableSizeTransformer, StateWithAvailableSizeTransformerInterface $stateWithAvailableSizeTransformer, SliderWithAvailableSizeTransformerInterface $sliderWithAvailableSizeTransformer, EmptyWithAvailableSizeTransformerInterface $emptyWithAvailableSizeTransformer)
    {
        $this->stepperWithAvailableSizeTransformer = $stepperWithAvailableSizeTransformer;
        $this->listWithAvailableSizeTransformer = $listWithAvailableSizeTransformer;
        $this->pushButtonWithAvailableSizeTransformer = $pushButtonWithAvailableSizeTransformer;
        $this->stateWithAvailableSizeTransformer = $stateWithAvailableSizeTransformer;
        $this->sliderWithAvailableSizeTransformer = $sliderWithAvailableSizeTransformer;
        $this->emptyWithAvailableSizeTransformer = $emptyWithAvailableSizeTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelItemForCapabilityInterface
    {
        $model = new PanelItemForCapability(self::requireDisplayType($data));

        self::applyLabel($model, $data);
        $this->applyStepper($model, $data);
        $this->applyList($model, $data);
        $this->applyPushButton($model, $data);
        $this->applyState($model, $data);
        $this->applySlider($model, $data);
        $this->applyEmpty($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEmpty(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_EMPTY])) {
            return;
        }
        if (!is_array($data[self::KEY_EMPTY])) {
            return;
        }
        $model->setEmpty($this->emptyWithAvailableSizeTransformer->transform($data[self::KEY_EMPTY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(PanelItemForCapability $model, array $data): void
    {
        if (empty($data[self::KEY_LABEL])) {
            return;
        }
        if (!is_string($data[self::KEY_LABEL])) {
            return;
        }
        $model->setLabel($data[self::KEY_LABEL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listWithAvailableSizeTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPushButton(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        if (!is_array($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        $model->setPushButton($this->pushButtonWithAvailableSizeTransformer->transform($data[self::KEY_PUSH_BUTTON]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderWithAvailableSizeTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->stateWithAvailableSizeTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStepper(PanelItemForCapability $model, array $data): void
    {
        if (!isset($data[self::KEY_STEPPER])) {
            return;
        }
        if (!is_array($data[self::KEY_STEPPER])) {
            return;
        }
        $model->setStepper($this->stepperWithAvailableSizeTransformer->transform($data[self::KEY_STEPPER]));
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
}
