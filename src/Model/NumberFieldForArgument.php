<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class NumberFieldForArgument implements NumberFieldForArgumentInterface
{
    private ?string $argumentType = null;
    private string $name;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): string
    {
        return $this->name;
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

    public function setArgumentType(?string $value): NumberFieldForArgumentInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): NumberFieldForArgumentInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): NumberFieldForArgumentInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): NumberFieldForArgumentInterface
    {
        $this->unit = $value;

        return $this;
    }
}
