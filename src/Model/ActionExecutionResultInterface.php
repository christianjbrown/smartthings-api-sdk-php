<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ActionExecutionResultInterface
{
    public function getActionId(): ?string;

    public function getBehavior(): ?BehaviorAbnormalExecutionResultInterface;

    /**
     * @return array<int, CommandActionExecutionResultInterface>
     */
    public function getCommand(): array;

    public function getIf(): ?IfActionExecutionResultInterface;

    public function getLocation(): ?LocationActionExecutionResultInterface;

    public function getSleep(): ?SleepActionExecutionResultInterface;

    public function setActionId(?string $value): self;

    public function setBehavior(?BehaviorAbnormalExecutionResultInterface $value): self;

    /**
     * @param array<int, CommandActionExecutionResultInterface> $value
     */
    public function setCommand(array $value): self;

    public function setIf(?IfActionExecutionResultInterface $value): self;

    public function setLocation(?LocationActionExecutionResultInterface $value): self;

    public function setSleep(?SleepActionExecutionResultInterface $value): self;
}
