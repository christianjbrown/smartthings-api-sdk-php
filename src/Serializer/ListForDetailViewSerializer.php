<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ListForDetailViewInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeCommandInterface;
use ChristianBrown\SmartThings\Model\ListWithAvailableSizeStateInterface;

use function array_filter;

final class ListForDetailViewSerializer implements ListForDetailViewSerializerInterface
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
    public function serialize(ListForDetailViewInterface $model): array
    {
        $serialized = [
            self::KEY_COMMAND => $this->serializeOptionalListWithAvailableSizeCommand($model->getCommand()),
            self::KEY_STATE => $this->serializeOptionalState($model->getState()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalListWithAvailableSizeCommand(?ListWithAvailableSizeCommandInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->listWithAvailableSizeCommandSerializer->serialize($value);
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
