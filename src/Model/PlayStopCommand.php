<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayStopCommand implements PlayStopCommandInterface
{
    private ?string $argumentType = null;
    private ?string $name = null;
    private ?string $play;
    private ?string $stop;

    public function __construct(?string $play, ?string $stop)
    {
        $this->play = $play;
        $this->stop = $stop;
    }

    public function getArgumentType(): ?string
    {
        return $this->argumentType;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getPlay(): ?string
    {
        return $this->play;
    }

    public function getStop(): ?string
    {
        return $this->stop;
    }

    public function setArgumentType(?string $value): PlayStopCommandInterface
    {
        $this->argumentType = $value;

        return $this;
    }

    public function setName(?string $value): PlayStopCommandInterface
    {
        $this->name = $value;

        return $this;
    }
}
