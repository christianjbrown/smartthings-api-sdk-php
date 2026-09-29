<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\TextButton;
use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;
use ChristianBrown\SmartThings\Model\TextButtonInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;
use function is_string;
use function sprintf;

final class TextButtonTransformer implements TextButtonTransformerInterface
{
    private TextButtonButtonsItemTransformerInterface $textButtonButtonsItemTransformer;

    public function __construct(TextButtonButtonsItemTransformerInterface $textButtonButtonsItemTransformer)
    {
        $this->textButtonButtonsItemTransformer = $textButtonButtonsItemTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): TextButtonInterface
    {
        $model = new TextButton($this->requireButtons($data));

        self::applyCommand($model, $data);
        self::applyValue($model, $data);
        self::applySupportedValues($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyCommand(TextButton $model, array $data): void
    {
        if (empty($data[self::KEY_COMMAND])) {
            return;
        }
        if (!is_string($data[self::KEY_COMMAND])) {
            return;
        }
        $model->setCommand($data[self::KEY_COMMAND]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applySupportedValues(TextButton $model, array $data): void
    {
        if (empty($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        if (!is_string($data[self::KEY_SUPPORTED_VALUES])) {
            return;
        }
        $model->setSupportedValues($data[self::KEY_SUPPORTED_VALUES]);
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private static function applyValue(TextButton $model, array $data): void
    {
        if (empty($data[self::KEY_VALUE])) {
            return;
        }
        if (!is_string($data[self::KEY_VALUE])) {
            return;
        }
        $model->setValue($data[self::KEY_VALUE]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TextButtonButtonsItemInterface>
     */
    private function requireButtons(array $data): array
    {
        if (!isset($data[self::KEY_BUTTONS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_BUTTONS));
        }
        if (!is_array($data[self::KEY_BUTTONS])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::KEY_BUTTONS));
        }

        return $this->transformListTextButtonButtonsItem($data[self::KEY_BUTTONS]);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, TextButtonButtonsItemInterface>
     */
    private function transformListTextButtonButtonsItem(array $data): array
    {
        return array_values(array_map(fn (array $item): TextButtonButtonsItemInterface => $this->textButtonButtonsItemTransformer->transform($item), array_filter($data, is_array(...))));
    }
}
