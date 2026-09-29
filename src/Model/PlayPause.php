<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class PlayPause implements PlayPauseInterface
{
    private PlayPauseCommandInterface $command;
    private PlayPauseStateInterface $state;

    public function __construct(PlayPauseCommandInterface $command, PlayPauseStateInterface $state)
    {
        $this->command = $command;
        $this->state = $state;
    }

    public function getCommand(): PlayPauseCommandInterface
    {
        return $this->command;
    }

    public function getState(): PlayPauseStateInterface
    {
        return $this->state;
    }
}
