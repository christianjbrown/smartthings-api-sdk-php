<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\GreaterThanOrEqualsConditionInterface;

/**
 * @extends NodeSerializerInterface<GreaterThanOrEqualsConditionInterface>
 */
interface GreaterThanOrEqualsConditionNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param GreaterThanOrEqualsConditionInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
