<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityConfiguration implements CapabilityConfigurationInterface
{
    /**
     * @var array<int, CapabilityConfigurationValueInterface>
     */
    private array $values;

    /**
     * @phpstan-param array<int, CapabilityConfigurationValueInterface> $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * @return array<int, CapabilityConfigurationValueInterface>
     */
    public function getValues(): array
    {
        return $this->values;
    }
}
