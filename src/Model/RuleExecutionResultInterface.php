<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RuleExecutionResultInterface
{
    /**
     * @return array<int, ActionExecutionResultInterface>
     */
    public function getActions(): array;

    public function getExecutionId(): string;

    public function getId(): string;

    public function getResult(): ?string;

    /**
     * @param array<int, ActionExecutionResultInterface> $value
     */
    public function setActions(array $value): self;

    public function setResult(?string $value): self;
}
