<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class IfActionSequence implements IfActionSequenceInterface
{
    private ?string $else = null;
    private ?string $then = null;

    public function getElse(): ?string
    {
        return $this->else;
    }

    public function getThen(): ?string
    {
        return $this->then;
    }

    public function setElse(?string $value): IfActionSequenceInterface
    {
        $this->else = $value;

        return $this;
    }

    public function setThen(?string $value): IfActionSequenceInterface
    {
        $this->then = $value;

        return $this;
    }
}
