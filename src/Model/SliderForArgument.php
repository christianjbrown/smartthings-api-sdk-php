<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SliderForArgument implements SliderForArgumentInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $argumentType = null;
    private ?string $name;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?float $step = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(array $range, ?string $name)
    {
        $this->range = $range;
        $this->name = $name;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return mixed[]
     */
    public function getRange(): array
    {
        return $this->range;
    }

    public function getStep(): ?float
    {
        return $this->step;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): SliderForArgumentInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setArgumentType(?string $value): SliderForArgumentInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setStep(?float $value): SliderForArgumentInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): SliderForArgumentInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): SliderForArgumentInterface
    {
        $this->unit = $value;

        return $this;
    }
}
