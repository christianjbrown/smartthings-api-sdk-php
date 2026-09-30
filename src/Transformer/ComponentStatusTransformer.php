<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;
use ChristianBrown\SmartThings\Model\ComponentStatus;
use ChristianBrown\SmartThings\Model\ComponentStatusInterface;

use function array_filter;
use function array_map;
use function is_array;

final class ComponentStatusTransformer implements ComponentStatusTransformerInterface
{
    private CapabilityStatusTransformerInterface $capabilityStatusTransformer;

    public function __construct(CapabilityStatusTransformerInterface $capabilityStatusTransformer)
    {
        $this->capabilityStatusTransformer = $capabilityStatusTransformer;
    }

    /**
     * @param mixed[] $data The component's capabilities, keyed by capability id
     */
    public function transform(array $data): ComponentStatusInterface
    {
        return (new ComponentStatus())->setCapabilities(
            array_map(
                fn (array $attributes): CapabilityStatusInterface => $this->capabilityStatusTransformer->transform($attributes),
                array_filter($data, is_array(...))
            )
        );
    }
}
