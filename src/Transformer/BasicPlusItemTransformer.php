<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItem;
use ChristianBrown\SmartThings\Model\BasicPlusItemActionsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class BasicPlusItemTransformer implements BasicPlusItemTransformerInterface
{
    private BasicPlusCameraTransformerInterface $basicPlusCameraTransformer;
    private BasicPlusItemActionsItemTransformerInterface $basicPlusItemActionsItemTransformer;
    private BasicPlusItemProgressBarsItemTransformerInterface $basicPlusItemProgressBarsItemTransformer;
    private BasicPlusLightTransformerInterface $basicPlusLightTransformer;
    private BasicPlusStateBoardItemTransformerInterface $basicPlusStateBoardItemTransformer;
    private BasicPlusTvTransformerInterface $basicPlusTvTransformer;
    private PanelForDeviceConfigTransformerInterface $panelForDeviceConfigTransformer;

    public function __construct(BasicPlusCameraTransformerInterface $basicPlusCameraTransformer, BasicPlusTvTransformerInterface $basicPlusTvTransformer, BasicPlusLightTransformerInterface $basicPlusLightTransformer, BasicPlusItemActionsItemTransformerInterface $basicPlusItemActionsItemTransformer, BasicPlusStateBoardItemTransformerInterface $basicPlusStateBoardItemTransformer, BasicPlusItemProgressBarsItemTransformerInterface $basicPlusItemProgressBarsItemTransformer, PanelForDeviceConfigTransformerInterface $panelForDeviceConfigTransformer)
    {
        $this->basicPlusCameraTransformer = $basicPlusCameraTransformer;
        $this->basicPlusTvTransformer = $basicPlusTvTransformer;
        $this->basicPlusLightTransformer = $basicPlusLightTransformer;
        $this->basicPlusItemActionsItemTransformer = $basicPlusItemActionsItemTransformer;
        $this->basicPlusStateBoardItemTransformer = $basicPlusStateBoardItemTransformer;
        $this->basicPlusItemProgressBarsItemTransformer = $basicPlusItemProgressBarsItemTransformer;
        $this->panelForDeviceConfigTransformer = $panelForDeviceConfigTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemInterface
    {
        $model = new BasicPlusItem(self::requireDisplayType($data));

        $this->applyCamera($model, $data);
        $this->applyTv($model, $data);
        $this->applyLight($model, $data);
        $this->applyActions($model, $data);
        $this->applyStateBoard($model, $data);
        $this->applyProgressBars($model, $data);
        $this->applyPanel($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyActions(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ACTIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_ACTIONS])) {
            return;
        }
        $model->setActions($this->transformListBasicPlusItemActionsItem($data[self::KEY_ACTIONS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyCamera(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_CAMERA])) {
            return;
        }
        if (!is_array($data[self::KEY_CAMERA])) {
            return;
        }
        $model->setCamera($this->basicPlusCameraTransformer->transform($data[self::KEY_CAMERA]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyLight(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIGHT])) {
            return;
        }
        if (!is_array($data[self::KEY_LIGHT])) {
            return;
        }
        $model->setLight($this->basicPlusLightTransformer->transform($data[self::KEY_LIGHT]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyPanel(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PANEL])) {
            return;
        }
        if (!is_array($data[self::KEY_PANEL])) {
            return;
        }
        $model->setPanel($this->panelForDeviceConfigTransformer->transform($data[self::KEY_PANEL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyProgressBars(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_PROGRESS_BARS])) {
            return;
        }
        if (!is_array($data[self::KEY_PROGRESS_BARS])) {
            return;
        }
        $model->setProgressBars($this->transformListBasicPlusItemProgressBarsItem($data[self::KEY_PROGRESS_BARS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyStateBoard(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_STATE_BOARD])) {
            return;
        }
        if (!is_array($data[self::KEY_STATE_BOARD])) {
            return;
        }
        $model->setStateBoard($this->transformListBasicPlusStateBoardItem($data[self::KEY_STATE_BOARD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTv(BasicPlusItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TV])) {
            return;
        }
        if (!is_array($data[self::KEY_TV])) {
            return;
        }
        $model->setTv($this->basicPlusTvTransformer->transform($data[self::KEY_TV]));
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
     * @return array<int, BasicPlusItemActionsItemInterface>
     */
    private function transformListBasicPlusItemActionsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusItemActionsItemInterface => $this->basicPlusItemActionsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusItemProgressBarsItemInterface>
     */
    private function transformListBasicPlusItemProgressBarsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusItemProgressBarsItemInterface => $this->basicPlusItemProgressBarsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusStateBoardItemInterface>
     */
    private function transformListBasicPlusStateBoardItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusStateBoardItemInterface => $this->basicPlusStateBoardItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
