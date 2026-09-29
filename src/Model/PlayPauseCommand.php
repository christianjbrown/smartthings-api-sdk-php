<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayPauseCommand implements PlayPauseCommandInterface
{
    private ?string $argumentType = null;
    private ?string $name = null;
    private string $pause;
    private string $play;

    public function __construct(string $play, string $pause)
    {
        $this->play = $play;
        $this->pause = $pause;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPause(): string
    {
        return $this->pause;
    }

    public function getPlay(): string
    {
        return $this->play;
    }

    public function setArgumentType(?string $value): PlayPauseCommandInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setName(?string $value): PlayPauseCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
