<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\TextFieldForAutomationAction;
use ChristianBrown\SmartThings\Model\TextFieldForAutomationActionInterface;

use function is_array;
use function is_string;

final class TextFieldForAutomationActionTransformer implements TextFieldForAutomationActionTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextFieldForAutomationActionInterface
    {
        $model = new TextFieldForAutomationAction(self::requireCommand($data));

        self::applyArgumentType($model, $data);
        self::applyRange($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(TextFieldForAutomationAction $model, array $data): void
    {
        if (empty($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        if (!is_string($data[self::KEY_ARGUMENT_TYPE])) {
            return;
        }
        $model->setArgumentType($data[self::KEY_ARGUMENT_TYPE]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyRange(TextFieldForAutomationAction $model, array $data): void
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
     * @param mixed[] $data
     */
    private static function requireCommand(array $data): ?string
    {
        if (empty($data[self::KEY_COMMAND])) {
            return null;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return null;
        }

        return $data[self::KEY_COMMAND];
    }
}
