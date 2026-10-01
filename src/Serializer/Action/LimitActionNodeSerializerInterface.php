<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\LimitActionInterface;

/**
 * @extends NodeSerializerInterface<LimitActionInterface>
 */
interface LimitActionNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param LimitActionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
