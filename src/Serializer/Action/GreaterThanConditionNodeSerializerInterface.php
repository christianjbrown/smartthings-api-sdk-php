<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\GreaterThanConditionInterface;

/**
 * @extends NodeSerializerInterface<GreaterThanConditionInterface>
 */
interface GreaterThanConditionNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param GreaterThanConditionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
