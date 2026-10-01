<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\SceneComponentInterface;

/**
 * @extends NodeTransformerInterface<SceneComponentInterface>
 */
interface SceneComponentNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneComponentInterface;
}
