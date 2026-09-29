<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StateItem implements StateItemInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private string $label;

    public function __construct(string $label)
    {
        $this->label = $label;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): StateItemInterface
    {
        $this->alternatives = $value;

        return $this;
    }
}
