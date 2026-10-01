<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;

/**
 * @extends NodeTransformerInterface<SceneDeviceGroupRequestInterface>
 */
interface SceneDeviceGroupRequestNodeTransformerInterface extends ActionTreeKeysInterface, NodeTransformerInterface
{
    /**
     * @param mixed[] $data
     */
    public function transform(array $data, NodeTransformerRegistryInterface $registry): SceneDeviceGroupRequestInterface;
}
