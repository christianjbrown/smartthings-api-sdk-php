<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\MultiArgCommandArgumentsItemInterface;
use ChristianBrown\SmartThings\Model\MultiArgCommandInterface;

use function array_filter;
use function array_map;

final class MultiArgCommandSerializer implements MultiArgCommandSerializerInterface
{
    private MultiArgCommandArgumentsItemSerializerInterface $multiArgCommandArgumentsItemSerializer;

    public function __construct(MultiArgCommandArgumentsItemSerializerInterface $multiArgCommandArgumentsItemSerializer)
    {
        $this->multiArgCommandArgumentsItemSerializer = $multiArgCommandArgumentsItemSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(MultiArgCommandInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $model->getCommand(),
            self::KEY_ARGUMENTS => $this->serializeArguments($model->getArguments()),
            self::KEY_SUPPORTED_VALUES => $model->getSupportedValues(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @param array<int, MultiArgCommandArgumentsItemInterface> $values
     *
     * @return array<int, mixed[]>
     */
    private function serializeArguments(array $values): array
    {
        return array_map(fn (MultiArgCommandArgumentsItemInterface $item): array => $this->multiArgCommandArgumentsItemSerializer->serialize($item), $values);
    }
}
