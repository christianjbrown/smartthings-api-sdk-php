<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityValue implements CapabilityValueInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $enabledValues = null;
    private string $key;
    private ?string $label = null;

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
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
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

    public function getLabel(): ?string
    {
        return $this->label;
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
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): CapabilityValueInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setEnabledValues(?array $value): CapabilityValueInterface
    {
        $this->enabledValues = $value;

        return $this;
    }

    public function setLabel(?string $value): CapabilityValueInterface
    {
        $this->label = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): CapabilityValueInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setStep(?float $value): CapabilityValueInterface
    {
        $this->step = $value;

        return $this;
    }
}
