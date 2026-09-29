<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListForArgumentInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;
use ChristianBrown\SmartThings\Model\NumberFieldForArgumentInterface;
use ChristianBrown\SmartThings\Model\SliderForArgumentInterface;
use ChristianBrown\SmartThings\Model\TextFieldForArgumentInterface;

use function array_filter;

final class MultiArgCommandArgumentsItemSerializer implements MultiArgCommandArgumentsItemSerializerInterface
{
    private ListForArgumentSerializerInterface $listForArgumentSerializer;
    private NumberFieldForArgumentSerializerInterface $numberFieldForArgumentSerializer;
    private SliderForArgumentSerializerInterface $sliderForArgumentSerializer;
    private TextFieldForArgumentSerializerInterface $textFieldForArgumentSerializer;

    public function __construct(SliderForArgumentSerializerInterface $sliderForArgumentSerializer, ListForArgumentSerializerInterface $listForArgumentSerializer, TextFieldForArgumentSerializerInterface $textFieldForArgumentSerializer, NumberFieldForArgumentSerializerInterface $numberFieldForArgumentSerializer)
    {
        $this->sliderForArgumentSerializer = $sliderForArgumentSerializer;
        $this->listForArgumentSerializer = $listForArgumentSerializer;
        $this->textFieldForArgumentSerializer = $textFieldForArgumentSerializer;
        $this->numberFieldForArgumentSerializer = $numberFieldForArgumentSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(MultiArgCommandArgumentsItemInterface $model): array
    {
        $serialized = [
            self::KEY_LABEL => $model->getLabel(),
            self::KEY_DISPLAY_TYPE => $model->getDisplayType(),
            self::KEY_SLIDER => $this->serializeOptionalSlider($model->getSlider()),
            self::KEY_LIST => $this->serializeOptionalList($model->getList()),
            self::KEY_TEXT_FIELD => $this->serializeOptionalTextField($model->getTextField()),
            self::KEY_NUMBER_FIELD => $this->serializeOptionalNumberField($model->getNumberField()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalList(?ListForArgumentInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listForArgumentSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalNumberField(?NumberFieldForArgumentInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->numberFieldForArgumentSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalSlider(?SliderForArgumentInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->sliderForArgumentSerializer->serialize($value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalTextField(?TextFieldForArgumentInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->textFieldForArgumentSerializer->serialize($value);
    }
}
