<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\BetweenConditionInterface;

/**
 * @extends NodeSerializerInterface<BetweenConditionInterface>
 */
interface BetweenConditionNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param BetweenConditionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
