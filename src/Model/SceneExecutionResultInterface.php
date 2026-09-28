<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SceneExecutionResultInterface
{
    public function getStatus(): ?string;

    public function setStatus(?string $value): self;
}
