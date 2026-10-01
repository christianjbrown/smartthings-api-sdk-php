<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\EveryActionInterface;

/**
 * @extends NodeTransformerInterface<EveryActionInterface>
 */
interface EveryActionNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): EveryActionInterface;
}
