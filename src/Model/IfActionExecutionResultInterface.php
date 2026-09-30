<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface IfActionExecutionResultInterface
{
    public function getResult(): ?string;

    public function setResult(?string $value): self;
}
