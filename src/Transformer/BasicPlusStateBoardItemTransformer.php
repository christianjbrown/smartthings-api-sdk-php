<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AlternativeItemInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardColorsInterface;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItem;
use ChristianBrown\SmartThings\Model\BasicPlusStateBoardItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_int;
use function is_string;

final class BasicPlusStateBoardItemTransformer implements BasicPlusStateBoardItemTransformerInterface
{
    private AlternativeItemTransformerInterface $alternativeItemTransformer;
    private BasicPlusStateBoardColorsTransformerInterface $basicPlusStateBoardColorsTransformer;
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(AlternativeItemTransformerInterface $alternativeItemTransformer, BasicPlusStateBoardColorsTransformerInterface $basicPlusStateBoardColorsTransformer, VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->alternativeItemTransformer = $alternativeItemTransformer;
        $this->basicPlusStateBoardColorsTransformer = $basicPlusStateBoardColorsTransformer;
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): BasicPlusStateBoardItemInterface
    {
        $model = new BasicPlusStateBoardItem(self::requireCapability($data), self::requireComponent($data), self::requireValue($data), self::requireLabel($data));

        self::applyVersion($model, $data);
        self::applyValueType($model, $data);
        self::applyUnit($model, $data);
        $this->applyAlternatives($model, $data);
        self::applyIconUrl($model, $data);
        $this->applyColors($model, $data);
        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAlternatives(BasicPlusStateBoardItem $model, array $data): void
    {
        if (!isset($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        if (!is_array($data[self::KEY_ALTERNATIVES])) {
            return;
        }
        $model->setAlternatives($this->transformListAlternativeItem($data[self::KEY_ALTERNATIVES]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyColors(BasicPlusStateBoardItem $model, array $data): void
    {
        if (!isset($data[self::KEY_COLORS])) {
            return;
        }
        if (!is_array($data[self::KEY_COLORS])) {
            return;
        }
        $model->setColors($this->transformListBasicPlusStateBoardColors($data[self::KEY_COLORS]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyIconUrl(BasicPlusStateBoardItem $model, array $data): void
    {
        if (empty($data[self::KEY_ICON_URL])) {
            return;
        }
        if (!is_string($data[self::KEY_ICON_URL])) {
            return;
        }
        $model->setIconUrl($data[self::KEY_ICON_URL]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(BasicPlusStateBoardItem $model, array $data): void
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
    private static function applyUnit(BasicPlusStateBoardItem $model, array $data): void
    {
        if (empty($data[self::KEY_UNIT])) {
            return;
        }
        if (!is_string($data[self::KEY_UNIT])) {
            return;
        }
        $model->setUnit($data[self::KEY_UNIT]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(BasicPlusStateBoardItem $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE_TYPE])) {
            return;
        }
        $model->setValueType($data[self::KEY_VALUE_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyVersion(BasicPlusStateBoardItem $model, array $data): void
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
    private function applyVisibleConditions(BasicPlusStateBoardItem $model, array $data): void
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

    /**
     * @param mixed[] $data
     */
    private static function requireValue(array $data): ?string
    {
        if (empty($data[self::KEY_VALUE])) {
            return null;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return null;
        }

        return $data[self::KEY_VALUE];
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, AlternativeItemInterface>
     */
    private function transformListAlternativeItem(array $data): array
    {
        return array_values(array_map(fn (array $item): AlternativeItemInterface => $this->alternativeItemTransformer->transform($item), array_filter($data, is_array(...))));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, BasicPlusStateBoardColorsInterface>
     */
    private function transformListBasicPlusStateBoardColors(array $data): array
    {
        return array_values(array_map(fn (array $item): BasicPlusStateBoardColorsInterface => $this->basicPlusStateBoardColorsTransformer->transform($item), array_filter($data, is_array(...))));
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
