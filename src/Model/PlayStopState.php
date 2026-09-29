<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayStopState implements PlayStopStateInterface
{
    /**
     * @var null|array<int, AlternativeItemInterface>
     */
    private ?array $alternatives = null;
    private string $play;
    private string $stop;
    private string $value;
    private ?string $valueType = null;

    public function __construct(string $value, string $play, string $stop)
    {
        $this->value = $value;
        $this->play = $play;
        $this->stop = $stop;
    }

    /**
     * @return null|array<int, AlternativeItemInterface>
     */
    public function getAlternatives(): ?array
    {
        return $this->alternatives;
    }

    public function getPlay(): string
    {
        return $this->play;
    }

    public function getStop(): string
    {
        return $this->stop;
    }

    public function getValue(): string
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
    public function setAlternatives(?array $value): PlayStopStateInterface
    {
        $this->alternatives = $value;

        return $this;
    }

    public function setValueType(?string $value): PlayStopStateInterface
    {
        $this->valueType = $value;

        return $this;
    }
}
