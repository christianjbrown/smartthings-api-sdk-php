<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PlayStopInterface
{
    public function getCommand(): ?PlayStopCommandInterface;

    public function getState(): ?PlayStopStateInterface;
}
