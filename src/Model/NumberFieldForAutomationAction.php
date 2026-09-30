<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class NumberFieldForAutomationAction implements NumberFieldForAutomationActionInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $argumentType = null;
    private ?string $command;
    private ?string $description = null;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $supportedValues = null;
    private ?string $unit = null;

    public function __construct(?string $command)
    {
        $this->command = $command;
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

    public function getCommand(): ?string
    {
        return $this->command;
    }

    public function getDescription(): ?string
    {
        return $this->description;
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

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): NumberFieldForAutomationActionInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setArgumentType(?string $value): NumberFieldForAutomationActionInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setDescription(?string $value): NumberFieldForAutomationActionInterface
    {
        $this->description = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): NumberFieldForAutomationActionInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): NumberFieldForAutomationActionInterface
    {
        $this->supportedValues = $value;

        return $this;
    }

    public function setUnit(?string $value): NumberFieldForAutomationActionInterface
    {
        $this->unit = $value;

        return $this;
    }
}
