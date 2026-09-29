<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleRequest implements RuleRequestInterface
{
    /**
     * @var array<int, ActionInterface|mixed[]>
     */
    private array $actions;
    private ?ActionSequenceInterface $actionSequence = null;
    private string $name;
    private ?string $sequence = null;
    private ?string $timeZoneId = null;

    /**
     * @phpstan-param array<int, ActionInterface|mixed[]> $actions
     */
    public function __construct(string $name, array $actions)
    {
        $this->name = $name;
        $this->actions = $actions;
    }

    /**
     * @return array<int, ActionInterface|mixed[]>
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getActionSequence(): ?ActionSequenceInterface
    {
        return $this->actionSequence;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSequence(): ?string
    {
        return $this->sequence;
    }

    public function getTimeZoneId(): ?string
    {
        return $this->timeZoneId;
    }

    public function setActionSequence(?ActionSequenceInterface $value): RuleRequestInterface
    {
        $this->actionSequence = $value;

        return $this;
    }

    public function setSequence(?string $value): RuleRequestInterface
    {
        $this->sequence = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): RuleRequestInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
