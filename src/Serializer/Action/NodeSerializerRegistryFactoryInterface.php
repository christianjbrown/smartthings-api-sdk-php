<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer\Action;

interface NodeSerializerRegistryFactoryInterface
{
    public function create(): NodeSerializerRegistryInterface;
}
