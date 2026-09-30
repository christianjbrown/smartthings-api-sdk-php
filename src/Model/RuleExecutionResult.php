<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleExecutionResult implements RuleExecutionResultInterface
{
    /**
     * @var array<int, ActionExecutionResultInterface>
     */
    private array $actions = [];
    private string $executionId;
    private string $id;
    private ?string $result = null;

    public function __construct(string $executionId, string $id)
    {
        $this->executionId = $executionId;
        $this->id = $id;
    }

    /**
     * @return array<int, ActionExecutionResultInterface>
     */
    public function getActions(): array
    {
        return $this->actions;
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

    /**
     * @param array<int, ActionExecutionResultInterface> $value
     */
    public function setActions(array $value): RuleExecutionResultInterface
    {
        $this->actions = $value;

        return $this;
    }

    public function setResult(?string $value): RuleExecutionResultInterface
    {
        $this->result = $value;

        return $this;
    }
}
