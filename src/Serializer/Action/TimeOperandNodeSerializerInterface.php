<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\TimeOperandInterface;

/**
 * @extends NodeSerializerInterface<TimeOperandInterface>
 */
interface TimeOperandNodeSerializerInterface extends NodeSerializerInterface, ActionTreeKeysInterface
{
    /**
     * @param TimeOperandInterface $value
     *
     * @return mixed[]
     */
    public function serialize(object $value, NodeSerializerRegistryInterface $registry): array;
}
