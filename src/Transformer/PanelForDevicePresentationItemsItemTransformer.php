<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItem;
use ChristianBrown\SmartThings\Model\PanelForDevicePresentationItemsItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;

final class PanelForDevicePresentationItemsItemTransformer implements PanelForDevicePresentationItemsItemTransformerInterface
{
    private EmptyForPanelItemTransformerInterface $emptyForPanelItemTransformer;
    private ListForPanelItemTransformerInterface $listForPanelItemTransformer;
    private PushButtonForPanelItemTransformerInterface $pushButtonForPanelItemTransformer;
    private SliderForPanelItemTransformerInterface $sliderForPanelItemTransformer;
    private StateForPanelItemTransformerInterface $stateForPanelItemTransformer;
    private StepperForPanelItemTransformerInterface $stepperForPanelItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(StepperForPanelItemTransformerInterface $stepperForPanelItemTransformer, ListForPanelItemTransformerInterface $listForPanelItemTransformer, PushButtonForPanelItemTransformerInterface $pushButtonForPanelItemTransformer, StateForPanelItemTransformerInterface $stateForPanelItemTransformer, SliderForPanelItemTransformerInterface $sliderForPanelItemTransformer, EmptyForPanelItemTransformerInterface $emptyForPanelItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->stepperForPanelItemTransformer = $stepperForPanelItemTransformer;
        $this->listForPanelItemTransformer = $listForPanelItemTransformer;
        $this->pushButtonForPanelItemTransformer = $pushButtonForPanelItemTransformer;
        $this->stateForPanelItemTransformer = $stateForPanelItemTransformer;
        $this->sliderForPanelItemTransformer = $sliderForPanelItemTransformer;
        $this->emptyForPanelItemTransformer = $emptyForPanelItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): PanelForDevicePresentationItemsItemInterface
    {
        $model = new PanelForDevicePresentationItemsItem(self::requireCapability($data), self::requireComponent($data), self::requireDisplayType($data));

        self::applyVersion($model, $data);
        self::applyLabel($model, $data);
        $this->applyStepper($model, $data);
        $this->applyList($model, $data);
        $this->applyPushButton($model, $data);
        $this->applyState($model, $data);
        $this->applySlider($model, $data);
        $this->applyEmpty($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);
        self::applyHideOnUnmatch($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyEmpty(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_EMPTY])) {
            return;
        }
        if (!is_array($data[self::KEY_EMPTY])) {
            return;
        }
        $model->setEmpty($this->emptyForPanelItemTransformer->transform($data[self::KEY_EMPTY]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideOnUnmatch(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        if (!is_bool($data[self::KEY_HIDE_ON_UNMATCH])) {
            return;
        }
        $model->setHideOnUnmatch($data[self::KEY_HIDE_ON_UNMATCH]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyLabel(PanelForDevicePresentationItemsItem $model, array $data): void
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
    private function applyList(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listForPanelItemTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (empty($data[self::KEY_OPERATOR])) {
            return;
        }
        if (!is_string($data[self::KEY_OPERATOR])) {
            return;
        }
        $model->setOperator($data[self::KEY_OPERATOR]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPushButton(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        if (!is_array($data[self::KEY_PUSH_BUTTON])) {
            return;
        }
        $model->setPushButton($this->pushButtonForPanelItemTransformer->transform($data[self::KEY_PUSH_BUTTON]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderForPanelItemTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyState(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE])) {
            return;
        }
        $model->setState($this->stateForPanelItemTransformer->transform($data[self::KEY_STATE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStepper(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STEPPER])) {
            return;
        }
        if (!is_array($data[self::KEY_STEPPER])) {
            return;
        }
        $model->setStepper($this->stepperForPanelItemTransformer->transform($data[self::KEY_STEPPER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(PanelForDevicePresentationItemsItem $model, array $data): void
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
    private function applyVisibleConditions(PanelForDevicePresentationItemsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setVisibleConditions($this->transformListVisibleCondition($data[self::KEY_VISIBLE_CONDITIONS]));
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
    private static function requireComponent(array $data): ?string
    {
        if (empty($data[self::KEY_COMPONENT])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMPONENT])) {
            return null;
        }

        return $data[self::KEY_COMPONENT];
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
     *
     * @return array<int, VisibleConditionInterface>
     */
    private function transformListVisibleCondition(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionInterface => $this->visibleConditionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
