<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\ActionTreeKeysInterface;
use ChristianBrown\SmartThings\Model\ActionInterface;

interface ActionSerializerInterface extends ActionTreeKeysInterface
{
    /**
     * @return mixed[]
     */
    public function serialize(ActionInterface $request): array;
}
