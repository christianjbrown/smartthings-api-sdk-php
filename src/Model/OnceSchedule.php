<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class OnceSchedule implements OnceScheduleInterface
{
    private ?bool $overwrite = null;
    private int $time;

    public function __construct(int $time)
    {
        $this->time = $time;
    }

    public function getOverwrite(): ?bool
    {
        return $this->overwrite;
    }

    public function getTime(): int
    {
        return $this->time;
    }

    public function setOverwrite(?bool $value): OnceScheduleInterface
    {
        $this->overwrite = $value;

        return $this;
    }
}
