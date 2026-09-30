<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Transformer;

use ChristianBrown\SmartThings\Model\AttributeStateInterface;
use ChristianBrown\SmartThings\Model\CapabilityStatus;
use ChristianBrown\SmartThings\Model\CapabilityStatusInterface;

use function array_filter;
use function array_map;
use function is_array;

final class CapabilityStatusTransformer implements CapabilityStatusTransformerInterface
{
    private AttributeStateTransformerInterface $attributeStateTransformer;

    public function __construct(AttributeStateTransformerInterface $attributeStateTransformer)
    {
        $this->attributeStateTransformer = $attributeStateTransformer;
    }

    /**
     * @param mixed[] $data The capability's attributes, keyed by attribute name
     */
    public function transform(array $data): CapabilityStatusInterface
    {
        return (new CapabilityStatus())->setAttributes(
            array_map(
                fn (array $state): AttributeStateInterface => $this->attributeStateTransformer->transform($state),
                array_filter($data, is_array(...))
            )
        );
    }
}
