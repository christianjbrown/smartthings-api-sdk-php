<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForArgument implements ListForArgumentInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;
    private ?string $argumentType = null;
    private ?string $name;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param array<int, AlternativeItemInterface> $alternatives
     */
    public function __construct(array $alternatives, ?string $name)
    {
        $this->alternatives = $alternatives;
        $this->name = $name;
    }

    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array
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

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function setArgumentType(?string $value): ListForArgumentInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): ListForArgumentInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
