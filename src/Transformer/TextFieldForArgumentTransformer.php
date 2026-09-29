<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TextFieldForArgument;
use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;

use function is_array;
use function is_string;
use function sprintf;

final class TextFieldForArgumentTransformer implements TextFieldForArgumentTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextFieldForArgumentInterface
    {
        $model = new TextFieldForArgument(self::requireName($data));

        self::applyArgumentType($model, $data);
        self::applyRange($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyArgumentType(TextFieldForArgument $model, array $data): void
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
    private static function applyRange(TextFieldForArgument $model, array $data): void
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
    private static function requireName(array $data): string
    {
        if (empty($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }
        if (!is_string($data[self::KEY_NAME])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_NAME));
        }

        return $data[self::KEY_NAME];
    }
}
