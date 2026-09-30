<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class StateWithAvailableSize implements StateWithAvailableSizeInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $availableSizes = null;
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

    /**
     * @return null|array<int, string>
     */
    public function getAvailableSizes(): ?array
    {
        return $this->availableSizes;
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
    public function setAlternatives(?array $value): StateWithAvailableSizeInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setAvailableSizes(?array $value): StateWithAvailableSizeInterface
    {
        $this->availableSizes = $value;

        return $this;
    }

    public function setUnit(?string $value): StateWithAvailableSizeInterface
    {
        $this->unit = $value;

        return $this;
    }
}
