<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\SceneDeviceGroupRequestInterface;

/**
 * @extends NodeSerializerInterface<SceneDeviceGroupRequestInterface>
 */
interface SceneDeviceGroupRequestNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param SceneDeviceGroupRequestInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
