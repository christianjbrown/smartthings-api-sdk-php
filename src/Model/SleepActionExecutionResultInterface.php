<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SleepActionExecutionResultInterface
{
    public function getResult(): ?string;

    public function setResult(?string $value): self;
}
