<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PlayPauseInterface
{
    public function getCommand(): ?PlayPauseCommandInterface;

    public function getState(): ?PlayPauseStateInterface;
}
