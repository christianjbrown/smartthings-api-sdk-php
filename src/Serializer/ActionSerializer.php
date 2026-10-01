<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Serializer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Serializer\Action\NodeSerializerRegistryInterface;

/**
 * Entry point for serializing the Rule action tree. Each model type is serialized by its own node
 * serializer, looked up in the registry by the model interface it serializes.
 */
final class ActionSerializer implements ActionSerializerInterface
{
    private NodeSerializerRegistryInterface $registry;

    public function __construct(NodeSerializerRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @return mixed[]
     */
    public function serialize(ActionInterface $request): array
    {
        return $this->registry->get(ActionInterface::class)->serialize($request, $this->registry);
    }
}
