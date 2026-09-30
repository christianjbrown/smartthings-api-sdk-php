<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\DescriptionItem;
use ChristianBrown\SmartThings\Model\DescriptionItemInterface;
use ChristianBrown\SmartThings\Model\VisibleConditionInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;

final class DescriptionItemTransformer implements DescriptionItemTransformerInterface
{
    private VisibleConditionTransformerInterface $visibleConditionTransformer;

    public function __construct(VisibleConditionTransformerInterface $visibleConditionTransformer)
    {
        $this->visibleConditionTransformer = $visibleConditionTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DescriptionItemInterface
    {
        $model = new DescriptionItem(self::requireLabel($data));

        self::applyOperator($model, $data);
        $this->applyVisibleConditions($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyOperator(DescriptionItem $model, array $data): void
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
    private function applyVisibleConditions(DescriptionItem $model, array $data): void
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
     *
     * @return array<int, VisibleConditionInterface>
     */
    private function transformListVisibleCondition(array $data): array
    {
        return array_values(array_map(fn (array $item): VisibleConditionInterface => $this->visibleConditionTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
