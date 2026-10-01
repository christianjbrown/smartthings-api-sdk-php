<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

/**
 * Serializes one model type of the Rule action tree into its JSON body. Nested models are serialized by
 * the serializer the registry holds for their type, so each type is one small class.
 *
 * @template T of object
 */
interface NodeSerializerInterface
{
    /**
     * @param T $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
