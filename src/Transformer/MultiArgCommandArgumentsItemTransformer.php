<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Exception\UnexpectedResponseException;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItem;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;

use function is_array;
use function is_string;
use function sprintf;

final class MultiArgCommandArgumentsItemTransformer implements MultiArgCommandArgumentsItemTransformerInterface
{
    private ListForArgumentTransformerInterface $listForArgumentTransformer;
    private NumberFieldForArgumentTransformerInterface $numberFieldForArgumentTransformer;
    private SliderForArgumentTransformerInterface $sliderForArgumentTransformer;
    private TextFieldForArgumentTransformerInterface $textFieldForArgumentTransformer;

    public function __construct(SliderForArgumentTransformerInterface $sliderForArgumentTransformer, ListForArgumentTransformerInterface $listForArgumentTransformer, TextFieldForArgumentTransformerInterface $textFieldForArgumentTransformer, NumberFieldForArgumentTransformerInterface $numberFieldForArgumentTransformer)
    {
        $this->sliderForArgumentTransformer = $sliderForArgumentTransformer;
        $this->listForArgumentTransformer = $listForArgumentTransformer;
        $this->textFieldForArgumentTransformer = $textFieldForArgumentTransformer;
        $this->numberFieldForArgumentTransformer = $numberFieldForArgumentTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): MultiArgCommandArgumentsItemInterface
    {
        $model = new MultiArgCommandArgumentsItem(self::requireLabel($data), self::requireDisplayType($data));

        $this->applySlider($model, $data);
        $this->applyList($model, $data);
        $this->applyTextField($model, $data);
        $this->applyNumberField($model, $data);

        return $model;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyList(MultiArgCommandArgumentsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_LIST])) {
            return;
        }
        if (!is_array($data[self::KEY_LIST])) {
            return;
        }
        $model->setList($this->listForArgumentTransformer->transform($data[self::KEY_LIST]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyNumberField(MultiArgCommandArgumentsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_NUMBER_FIELD])) {
            return;
        }
        $model->setNumberField($this->numberFieldForArgumentTransformer->transform($data[self::KEY_NUMBER_FIELD]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applySlider(MultiArgCommandArgumentsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_SLIDER])) {
            return;
        }
        if (!is_array($data[self::KEY_SLIDER])) {
            return;
        }
        $model->setSlider($this->sliderForArgumentTransformer->transform($data[self::KEY_SLIDER]));
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyTextField(MultiArgCommandArgumentsItem $model, array $data): void
    {
        if (!isset($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        if (!is_array($data[self::KEY_TEXT_FIELD])) {
            return;
        }
        $model->setTextField($this->textFieldForArgumentTransformer->transform($data[self::KEY_TEXT_FIELD]));
    }

    /**
     * @param mixed[] $data
     */
    private static function requireDisplayType(array $data): string
    {
        if (empty($data[self::KEY_DISPLAY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DISPLAY_TYPE));
        }
        if (!is_string($data[self::KEY_DISPLAY_TYPE])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_DISPLAY_TYPE));
        }

        return $data[self::KEY_DISPLAY_TYPE];
    }

    /**
     * @param mixed[] $data
     */
    private static function requireLabel(array $data): string
    {
        if (empty($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }
        if (!is_string($data[self::KEY_LABEL])) {
            throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_STRING_SPRINTF, self::KEY_LABEL));
        }

        return $data[self::KEY_LABEL];
    }
}
