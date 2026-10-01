<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\ActionInterface;
use ChristianBrown\SmartThings\Model\ActionSequenceInterface;
use ChristianBrown\SmartThings\Transformer\Action\NodeTransformerRegistryInterface;

use function array_filter;
use function array_map;
use function array_values;
use function is_array;

/**
 * Entry point for the Rule action tree. Each model type is built by its own node transformer,
 * looked up in the registry by the model interface it builds.
 */
final class ActionTransformer implements ActionTransformerInterface
{
    private NodeTransformerRegistryInterface $registry;

    public function __construct(NodeTransformerRegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): ActionInterface
    {
        return $this->registry->get(ActionInterface::class)->transform($data, $this->registry);
    }

    /**
     * @param mixed[] $data
     */
    public function transformActionSequence(array $data): ActionSequenceInterface
    {
        return $this->registry->get(ActionSequenceInterface::class)->transform($data, $this->registry);
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionInterface>
     */
    public function transformAll(array $data): array
    {
        return array_values($this->transformMap($data));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ActionSequenceInterface>
     */
    public function transformAllActionSequence(array $data): array
    {
        return array_values($this->transformMapActionSequence($data));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionInterface>
     */
    public function transformMap(array $data): array
    {
        $transformer = $this->registry->get(ActionInterface::class);

        return array_map(fn (array $item): ActionInterface => $transformer->transform($item, $this->registry), array_filter($data, is_array(...)));
    }

    /**
     * @param mixed[] $data
     *
     * @return array<array-key, ActionSequenceInterface>
     */
    public function transformMapActionSequence(array $data): array
    {
        $transformer = $this->registry->get(ActionSequenceInterface::class);

        return array_map(fn (array $item): ActionSequenceInterface => $transformer->transform($item, $this->registry), array_filter($data, is_array(...)));
    }
}
