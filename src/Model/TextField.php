<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TextField implements TextFieldInterface
{
    private ?string $argumentType = null;
    private string $command;

    /**
     * @var null|mixed[]
     */
    private ?array $range = null;
    private ?string $value = null;
    private ?string $valueType = null;

    public function __construct(string $command)
    {
        $this->command = $command;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getCommand(): string
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setArgumentType(?string $value): TextFieldInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setRange(?array $value): TextFieldInterface
    {
        $this->range = $value;

        return $this;
    }

    public function setValue(?string $value): TextFieldInterface
    {
        $this->value = $value;

        return $this;
    }

    public function setValueType(?string $value): TextFieldInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
