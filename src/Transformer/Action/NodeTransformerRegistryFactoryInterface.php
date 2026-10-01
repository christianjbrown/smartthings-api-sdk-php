<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer\Action;

interface NodeTransformerRegistryFactoryInterface
{
    public function create(): NodeTransformerRegistryInterface;
}
