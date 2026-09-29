<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ListForPanelItemState implements ListForPanelItemStateInterface
{
    /**
     * @var array<int, AlternativeItemInterface>
     */
    private array $alternatives;
    private string $value;
    private ?string $valueType = null;

    /**
     * @phpstan-param array<int, AlternativeItemInterface> $alternatives
     */
    public function __construct(string $value, array $alternatives)
    {
        $this->value = $value;
        $this->alternatives = $alternatives;
    }

    /**
     * @return array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): array
    {
        return $this->alternatives;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    public function setValueType(?string $value): ListForPanelItemStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
