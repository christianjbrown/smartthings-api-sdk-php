<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForPanelItemCommand implements ListForPanelItemCommandInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;
    private ?string $argumentType = null;
    private ?string $description = null;
    private ?string $name = null;
    private ?string $supportedValues = null;

    /**
     * @phpstan-param array<int, AlternativeItemInterface> $alternatives
     */
    public function __construct(array $alternatives)
    {
        $this->alternatives = $alternatives;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSupportedValues(): ?string
    {
        return $this->supportedValues;
    }

    public function setArgumentType(?string $value): ListForPanelItemCommandInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setDescription(?string $value): ListForPanelItemCommandInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setName(?string $value): ListForPanelItemCommandInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setSupportedValues(?string $value): ListForPanelItemCommandInterface
    {
        $this->supportedValues = $value;

        return $this;
    }
}
