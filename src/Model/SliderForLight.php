<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SliderForLight implements SliderForLightInterface
{
    private ?string $argumentType = null;
    private ?string $capability;
    private ?string $command;
    private ?string $component;
    private ?string $label;

    /**
     * @var mixed[]
     */
    private array $range;
    private ?float $step = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;
    private ?string $value;
    private ?string $valueType = null;
    private ?int $version = null;

    /**
     * @phpstan-param mixed[] $range
     */
    public function __construct(?string $component, ?string $capability, array $range, ?string $command, ?string $value, ?string $label)
    {
        $this->component = $component;
        $this->capability = $capability;
        $this->range = $range;
        $this->command = $command;
        $this->value = $value;
        $this->label = $label;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    public function getLabel(): ?string
    {
        return $this->label;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function getVersion(): ?int
    {
        return $this->version;
    }

    public function setArgumentType(?string $value): SliderForLightInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setStep(?float $value): SliderForLightInterface
    {
        $this->step = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): SliderForLightInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): SliderForLightInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValueType(?string $value): SliderForLightInterface
    {
        $this->valueType = $value;

        return $this;
    }

    public function setVersion(?int $value): SliderForLightInterface
    {
        $this->version = $value;

        return $this;
    }
}
