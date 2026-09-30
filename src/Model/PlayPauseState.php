<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayPauseState implements PlayPauseStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private ?string $pause;
    private ?string $play;
    private ?string $value;
    private ?string $valueType = null;

    public function __construct(?string $value, ?string $play, ?string $pause)
    {
        $this->value = $value;
        $this->play = $play;
        $this->pause = $pause;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getPause(): ?string
    {
        return $this->pause;
    }

    public function getPlay(): ?string
    {
        return $this->play;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getValueType(): ?string
    {
        return $this->valueType;
    }

    /**
     * @param null|array<int, AlternativeItemInterface> $value
     */
    public function setAlternatives(?array $value): PlayPauseStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setValueType(?string $value): PlayPauseStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
