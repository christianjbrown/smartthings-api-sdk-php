<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RuleExecutionResultInterface
{
    public function getExecutionId(): string;

    public function getId(): string;

    public function getResult(): ?string;

    public function setResult(?string $value): self;
}
