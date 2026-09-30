<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusTv;
use ChristianBrown\SmartThings\Model\BasicPlusTvInterface;
use ChristianBrown\SmartThings\Model\ButtonForTvInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_bool;
use function is_string;

final class BasicPlusTvTransformer implements BasicPlusTvTransformerInterface
{
    private BasicPlusTvChannelTransformerInterface $basicPlusTvChannelTransformer;
    private BasicPlusTvDirectionalPadTransformerInterface $basicPlusTvDirectionalPadTransformer;
    private BasicPlusTvVolumeTransformerInterface $basicPlusTvVolumeTransformer;
    private ButtonForTvTransformerInterface $buttonForTvTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(BasicPlusTvVolumeTransformerInterface $basicPlusTvVolumeTransformer, ButtonForTvTransformerInterface $buttonForTvTransformer, BasicPlusTvChannelTransformerInterface $basicPlusTvChannelTransformer, BasicPlusTvDirectionalPadTransformerInterface $basicPlusTvDirectionalPadTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->basicPlusTvVolumeTransformer = $basicPlusTvVolumeTransformer;
        $this->buttonForTvTransformer = $buttonForTvTransformer;
        $this->basicPlusTvChannelTransformer = $basicPlusTvChannelTransformer;
        $this->basicPlusTvDirectionalPadTransformer = $basicPlusTvDirectionalPadTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusTvInterface
    {
        $model = new BasicPlusTv($this->requireButtons($data));

        $this->applyVolume($model, $data);
        $this->applyChannel($model, $data);
        $this->applyDirectionalPad($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);
        self::applyHideDashboardActions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyChannel(BasicPlusTv $model, array $data): void
    {
        if (!isset($data[self::KEY_CHANNEL])) {
            return;
        }
        if (!is_array($data[self::KEY_CHANNEL])) {
            return;
        }
        $model->setChannel($this->basicPlusTvChannelTransformer->transform($data[self::KEY_CHANNEL]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyDirectionalPad(BasicPlusTv $model, array $data): void
    {
        if (!isset($data[self::KEY_DIRECTIONAL_PAD])) {
            return;
        }
        if (!is_array($data[self::KEY_DIRECTIONAL_PAD])) {
            return;
        }
        $model->setDirectionalPad($this->basicPlusTvDirectionalPadTransformer->transform($data[self::KEY_DIRECTIONAL_PAD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyHideDashboardActions(BasicPlusTv $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(BasicPlusTv $model, array $data): void
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
    private function applyVisibleConditions(BasicPlusTv $model, array $data): void
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
     * @phpstan-param mixed[] $data
     */
    private function applyVolume(BasicPlusTv $model, array $data): void
    {
        if (!isset($data[self::KEY_VOLUME])) {
            return;
        }
        if (!is_array($data[self::KEY_VOLUME])) {
            return;
        }
        $model->setVolume($this->basicPlusTvVolumeTransformer->transform($data[self::KEY_VOLUME]));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ButtonForTvInterface>
     */
    private function requireButtons(array $data): array
    {
        if (!isset($data[self::KEY_BUTTONS])) {
            return [];
        }
        if (!is_array($data[self::KEY_BUTTONS])) {
            return [];
        }

        return $this->transformListButtonForTv($data[self::KEY_BUTTONS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ButtonForTvInterface>
     */
    private function transformListButtonForTv(array $data): array
    {
        return array_values(array_map(fn (array $item): ButtonForTvInterface => $this->buttonForTvTransformer->transform($item), array_filter($data, is_array(...))));
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
