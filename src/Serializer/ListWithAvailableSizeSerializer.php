<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListWithAvailableSizeInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;

use function array_filter;

final class ListWithAvailableSizeSerializer implements ListWithAvailableSizeSerializerInterface
{
    private ListWithAvailableSizeCommandSerializerInterface $listWithAvailableSizeCommandSerializer;
    private ListWithAvailableSizeStateSerializerInterface $listWithAvailableSizeStateSerializer;

    public function __construct(ListWithAvailableSizeCommandSerializerInterface $listWithAvailableSizeCommandSerializer, ListWithAvailableSizeStateSerializerInterface $listWithAvailableSizeStateSerializer)
    {
        $this->listWithAvailableSizeCommandSerializer = $listWithAvailableSizeCommandSerializer;
        $this->listWithAvailableSizeStateSerializer = $listWithAvailableSizeStateSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ListWithAvailableSizeInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $this->listWithAvailableSizeCommandSerializer->serialize($model->getCommand()),
            self::KEY_STATE => $this->serializeOptionalState($model->getState()),
            self::KEY_AVAILABLE_SIZES => $model->getAvailableSizes(),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalState(?ListWithAvailableSizeStateInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listWithAvailableSizeStateSerializer->serialize($value);
    }
}
