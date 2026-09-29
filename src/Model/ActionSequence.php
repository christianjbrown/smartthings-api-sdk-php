<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ActionSequence implements ActionSequenceInterface
{
    private ?string $actions = null;

    public function getActions(): ?string
    {
        return $this->actions;
    }

    public function setActions(?string $value): ActionSequenceInterface
    {
        $this->actions = $value;

        return $this;
    }
}
