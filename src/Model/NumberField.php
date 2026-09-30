<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class NumberField implements NumberFieldInterface
{
    private ?string $argumentType = null;
    private ?string $command;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;
    private ?string $value = null;
    private ?string $valueType = null;

    public function __construct(?string $command)
    {
        $this->command = $command;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): ?string
    {
        return $this->command;
    }

    /**
     * @return null|mixed[]
     */
    public function getRange(): ?array
    {
        return $this->range;
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

    public function setArgumentType(?string $value): NumberFieldInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): NumberFieldInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): NumberFieldInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): NumberFieldInterface
    {
        $this->unit = $value;

        return $this;
    }

    public function setValue(?string $value): NumberFieldInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): NumberFieldInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
