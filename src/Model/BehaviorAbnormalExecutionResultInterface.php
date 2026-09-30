<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface BehaviorAbnormalExecutionResultInterface
{
    public function getReason(): ?string;

    public function getResult(): ?string;

    public function setReason(?string $value): self;

    public function setResult(?string $value): self;
}
