<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListInterface;
use ChristianBrown\SmartThings\Model\SupportedValuesForDynamicListValueMapInterface;

use function array_filter;

final class SupportedValuesForDynamicListSerializer implements SupportedValuesForDynamicListSerializerInterface
{
    private SupportedValuesForDynamicListValueMapSerializerInterface $supportedValuesForDynamicListValueMapSerializer;

    public function __construct(SupportedValuesForDynamicListValueMapSerializerInterface $supportedValuesForDynamicListValueMapSerializer)
    {
        $this->supportedValuesForDynamicListValueMapSerializer = $supportedValuesForDynamicListValueMapSerializer;
    }

    /**
     * @return mixed[]
     */
    public function serialize(SupportedValuesForDynamicListInterface $model): array
    {
        $serialized = [
            self::KEY_VALUE => $model->getValue(),
            self::KEY_VALUE_MAP => $this->serializeOptionalValueMap($model->getValueMap()),
        ];

        // Omit null optionals rather than sending them as explicit nulls.
        return array_filter($serialized, static fn (mixed $value): bool => null !== $value);
    }

    /**
     * @return null|mixed[]
     */
    private function serializeOptionalValueMap(?SupportedValuesForDynamicListValueMapInterface $value): ?array
    {
        if (null === $value) {
            return null;
        }

        return $this->supportedValuesForDynamicListValueMapSerializer->serialize($value);
    }
}
