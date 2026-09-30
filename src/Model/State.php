<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class State implements StateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $label;
    private ?string $unit = null;

    public function __construct(?string $label)
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

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): StateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setUnit(?string $value): StateInterface
    {
        $this->unit = $value;

        return $this;
    }
}
