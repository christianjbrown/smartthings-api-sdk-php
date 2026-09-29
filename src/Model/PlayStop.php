<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayStop implements PlayStopInterface
{
    private PlayStopCommandInterface $command;
    private PlayStopStateInterface $state;

    public function __construct(PlayStopCommandInterface $command, PlayStopStateInterface $state)
    {
        $this->command = $command;
        $this->state = $state;
    }

    public function getCommand(): PlayStopCommandInterface
    {
        return $this->command;
    }

    public function getState(): PlayStopStateInterface
    {
        return $this->state;
    }
}
