<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityConfigurationValue implements CapabilityConfigurationValueInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $enabledValues = null;
    private string $key;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?float $step = null;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return null|array<int, string>
     */
    public function getEnabledValues(): ?array
    {
        return $this->enabledValues;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setEnabledValues(?array $value): CapabilityConfigurationValueInterface
    {
        $this->enabledValues = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): CapabilityConfigurationValueInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setStep(?float $value): CapabilityConfigurationValueInterface
    {
        $this->step = $value;

        return $this;
    }
}
