<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusLight;
use ChristianBrown\SmartThings\Model\BasicPlusLightInterface;
use ChristianBrown\SmartThings\Model\SliderForLightInterface;

use function is_array;
use function is_bool;

final class BasicPlusLightTransformer implements BasicPlusLightTransformerInterface
{
    private BasicPlusLightColorControlTransformerInterface $basicPlusLightColorControlTransformer;
    private SliderForLightTransformerInterface $sliderForLightTransformer;

    public function __construct(SliderForLightTransformerInterface $sliderForLightTransformer, BasicPlusLightColorControlTransformerInterface $basicPlusLightColorControlTransformer)
    {
        $this->sliderForLightTransformer = $sliderForLightTransformer;
        $this->basicPlusLightColorControlTransformer = $basicPlusLightColorControlTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusLightInterface
    {
        $model = new BasicPlusLight($this->requireDimmer($data));

        $this->applyColorTemperature($model, $data);
        $this->applyColorControl($model, $data);
        self::applyHideDashboardActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyColorControl(BasicPlusLight $model, array $data): void
    {
        if (!isset($data[self::KEY_COLOR_CONTROL])) {
            return;
        }
        if (!is_array($data[self::KEY_COLOR_CONTROL])) {
            return;
        }
        $model->setColorControl($this->basicPlusLightColorControlTransformer->transform($data[self::KEY_COLOR_CONTROL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyColorTemperature(BasicPlusLight $model, array $data): void
    {
        if (!isset($data[self::KEY_COLOR_TEMPERATURE])) {
            return;
        }
        if (!is_array($data[self::KEY_COLOR_TEMPERATURE])) {
            return;
        }
        $model->setColorTemperature($this->sliderForLightTransformer->transform($data[self::KEY_COLOR_TEMPERATURE]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideDashboardActions(BasicPlusLight $model, array $data): void
    {
        if (!isset($data[self::KEY_HIDE_DASHBOARD_ACTIONS])) {
            return;
        }
        if (!is_bool($data[self::KEY_HIDE_DASHBOARD_ACTIONS])) {
            return;
        }
        $model->setHideDashboardActions($data[self::KEY_HIDE_DASHBOARD_ACTIONS]);
    }

    /**
     * @param mixed[] $data
     */
    private function requireDimmer(array $data): ?SliderForLightInterface
    {
        if (!isset($data[self::KEY_DIMMER])) {
            return null;
        }
        if (!is_array($data[self::KEY_DIMMER])) {
            return null;
        }

        return $this->sliderForLightTransformer->transform($data[self::KEY_DIMMER]);
    }
}
