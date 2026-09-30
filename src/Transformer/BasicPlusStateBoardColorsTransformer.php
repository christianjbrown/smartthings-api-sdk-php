<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColors;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionForColorItemInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class BasicPlusStateBoardColorsTransformer implements BasicPlusStateBoardColorsTransformerInterface
{
    private VisibleConditionForColorItemTransformerInterface $visibleConditionForColorItemTransformer;

    public function __construct(VisibleConditionForColorItemTransformerInterface $visibleConditionForColorItemTransformer)
    {
        $this->visibleConditionForColorItemTransformer = $visibleConditionForColorItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusStateBoardColorsInterface
    {
        $model = new BasicPlusStateBoardColors(self::requireColor($data));

        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(BasicPlusStateBoardColors $model, array $data): void
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
    private function applyVisibleConditions(BasicPlusStateBoardColors $model, array $data): void
    {
        if (!isset($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        if (!is_array($data[self::KEY_VISIBLE_CONDITIONS])) {
            return;
        }
        $model->setVisibleConditions($this->transformListVisibleConditionForColorItem($data[self::KEY_VISIBLE_CONDITIONS]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireColor(array $data): ?string
    {
        if (empty($data[self::KEY_COLOR])) {
            return null;
        }
        if (!is_string($data[self::KEY_COLOR])) {
            return null;
        }

        return $data[self::KEY_COLOR];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, VisibleConditionForColorItemInterface>
     */
    private function transformListVisibleConditionForColorItem(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionForColorItemInterface => $this->visibleConditionForColorItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
