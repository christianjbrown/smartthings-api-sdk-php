<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\TextButtonButtonsItemInterface;
use ChristianBrown\SmartThings\Model\TextButtonInterface;

use function array_filter;
use function array_map;

final class TextButtonSerializer implements TextButtonSerializerInterface
{
    private TextButtonButtonsItemSerializerInterface $textButtonButtonsItemSerializer;

    public function __construct(TextButtonButtonsItemSerializerInterface $textButtonButtonsItemSerializer)
    {
        $this->textButtonButtonsItemSerializer = $textButtonButtonsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(TextButtonInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_VALUE => $model->getValue(),
            self::KEY_BUTTONS => $this->serializeButtons($model->getButtons()),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, TextButtonButtonsItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeButtons(array $values): array
    {
        return array_map(fn (TextButtonButtonsItemInterface $item): array => $this->textButtonButtonsItemSerializer->serialize($item), $values);
    }
}
