<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ActionExecutionResult implements ActionExecutionResultInterface
{
    private ?string $actionId = null;
    private ?BehaviorAbnormalExecutionResultInterface $behavior = null;

    /**
     * @var array<int, CommandActionExecutionResultInterface>
     */
    private array $command = [];
    private ?IfActionExecutionResultInterface $if = null;
    private ?LocationActionExecutionResultInterface $location = null;
    private ?SleepActionExecutionResultInterface $sleep = null;

    public function getActionId(): ?string
    {
        return $this->actionId;
    }

    public function getBehavior(): ?BehaviorAbnormalExecutionResultInterface
    {
        return $this->behavior;
    }

    /**
     * @return array<int, CommandActionExecutionResultInterface>
     */
    public function getCommand(): array
    {
        return $this->command;
    }

    public function getIf(): ?IfActionExecutionResultInterface
    {
        return $this->if;
    }

    public function getLocation(): ?LocationActionExecutionResultInterface
    {
        return $this->location;
    }

    public function getSleep(): ?SleepActionExecutionResultInterface
    {
        return $this->sleep;
    }

    public function setActionId(?string $value): ActionExecutionResultInterface
    {
        $this->actionId = $value;

        return $this;
    }

    public function setBehavior(?BehaviorAbnormalExecutionResultInterface $value): ActionExecutionResultInterface
    {
        $this->behavior = $value;

        return $this;
    }

    /**
     * @param array<int, CommandActionExecutionResultInterface> $value
     */
    public function setCommand(array $value): ActionExecutionResultInterface
    {
        $this->command = $value;

        return $this;
    }

    public function setIf(?IfActionExecutionResultInterface $value): ActionExecutionResultInterface
    {
        $this->if = $value;

        return $this;
    }

    public function setLocation(?LocationActionExecutionResultInterface $value): ActionExecutionResultInterface
    {
        $this->location = $value;

        return $this;
    }

    public function setSleep(?SleepActionExecutionResultInterface $value): ActionExecutionResultInterface
    {
        $this->sleep = $value;

        return $this;
    }
}
