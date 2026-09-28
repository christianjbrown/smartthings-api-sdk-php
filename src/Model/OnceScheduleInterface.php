<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OnceScheduleInterface
{
    public function getOverwrite(): ?bool;

    public function getTime(): int;

    public function setOverwrite(?bool $value): self;
}
