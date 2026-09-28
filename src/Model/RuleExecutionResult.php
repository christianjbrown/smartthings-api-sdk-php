<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleExecutionResult implements RuleExecutionResultInterface
{
    private string $executionId;
    private string $id;
    private ?string $result = null;

    public function __construct(string $executionId, string $id)
    {
        $this->executionId = $executionId;
        $this->id = $id;
    }

    public function getExecutionId(): string
    {
        return $this->executionId;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(?string $value): RuleExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
