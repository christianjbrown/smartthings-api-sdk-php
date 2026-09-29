<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItem;
use ChristianBrown\SmartThings\Model\BasicPlusItemProgressBarsItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusProgressBarsStateItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class BasicPlusItemProgressBarsItemTransformer implements BasicPlusItemProgressBarsItemTransformerInterface
{
    private BasicPlusProgressBarsBarItemTransformerInterface $basicPlusProgressBarsBarItemTransformer;
    private BasicPlusProgressBarsStateItemTransformerInterface $basicPlusProgressBarsStateItemTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(BasicPlusProgressBarsStateItemTransformerInterface $basicPlusProgressBarsStateItemTransformer, BasicPlusProgressBarsBarItemTransformerInterface $basicPlusProgressBarsBarItemTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->basicPlusProgressBarsStateItemTransformer = $basicPlusProgressBarsStateItemTransformer;
        $this->basicPlusProgressBarsBarItemTransformer = $basicPlusProgressBarsBarItemTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusItemProgressBarsItemInterface
    {
        $model = new BasicPlusItemProgressBarsItem();

        $this->applyHeaders($model, $data);
        $this->applyBar($model, $data);
        $this->applyFooters($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyBar(BasicPlusItemProgressBarsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_BAR])) {
            return;
        }
        if (!is_array($data[self::KEY_BAR])) {
            return;
        }
        $model->setBar($this->basicPlusProgressBarsBarItemTransformer->transform($data[self::KEY_BAR]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyFooters(BasicPlusItemProgressBarsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_FOOTERS])) {
            return;
        }
        if (!is_array($data[self::KEY_FOOTERS])) {
            return;
        }
        $model->setFooters($this->transformListBasicPlusProgressBarsStateItem($data[self::KEY_FOOTERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyHeaders(BasicPlusItemProgressBarsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_HEADERS])) {
            return;
        }
        if (!is_array($data[self::KEY_HEADERS])) {
            return;
        }
        $model->setHeaders($this->transformListBasicPlusProgressBarsStateItem($data[self::KEY_HEADERS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(BasicPlusItemProgressBarsItem $model, array $data): void
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
    private function applyVisibleConditions(BasicPlusItemProgressBarsItem $model, array $data): void
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
     *
     * @return array<int, BasicPlusProgressBarsStateItemInterface>
     */
    private function transformListBasicPlusProgressBarsStateItem(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusProgressBarsStateItemInterface => $this->basicPlusProgressBarsStateItemTransformer->transform($item), array_filter($data, is_array(...))));
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
