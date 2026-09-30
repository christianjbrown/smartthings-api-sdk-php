<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StateForPanelItem implements StateForPanelItemInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $label;
    private ?string $size;
    private ?string $unit = null;

    public function __construct(?string $label, ?string $size)
    {
        $this->label = $label;
        $this->size = $size;
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

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): StateForPanelItemInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setUnit(?string $value): StateForPanelItemInterface
    {
        $this->unit = $value;

        return $this;
    }
}
