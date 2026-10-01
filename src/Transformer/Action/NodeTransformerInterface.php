<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

/**
 * Builds one model type of the Rule action tree from its decoded JSON. Nested models are built by
 * the transformer the registry holds for their type, so each type is one small class.
 *
 * @template-covariant T of object
 */
interface NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     *
     * @return T
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): object;
}
