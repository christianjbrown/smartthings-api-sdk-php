<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityStatus implements CapabilityStatusInterface
{
    /**
     * @var array<array-key, AttributeStateInterface>
     */
    private array $attributes = [];

    /**
     * @return array<array-key, AttributeStateInterface>
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array<array-key, AttributeStateInterface> $value
     */
    public function setAttributes(array $value): CapabilityStatusInterface
    {
        $this->attributes = $value;

        return $this;
    }
}
