<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationCondition;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationConditionInterface;

use function is_array;
use function is_string;

final class TextFieldForAutomationConditionTransformer implements TextFieldForAutomationConditionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextFieldForAutomationConditionInterface
    {
        $model = new TextFieldForAutomationCondition(self::requireValue($data));

        self::applyValueType($model, $data);
        self::applyRange($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRange(TextFieldForAutomationCondition $model, array $data): void
    {
        if (!isset($data[self::KEY_RANGE])) {
            return;
        }
        if (!is_array($data[self::KEY_RANGE])) {
            return;
        }
        $model->setRange($data[self::KEY_RANGE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValueType(TextFieldForAutomationCondition $model, array $data): void
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
}
