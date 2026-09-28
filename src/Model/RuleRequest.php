<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class RuleRequest implements RuleRequestInterface
{
    /**
     * @var array<int, mixed[]>
     */
    private array $actions;
    private string $name;
    private ?string $sequence = null;
    private ?string $timeZoneId = null;

    /**
     * @phpstan-param array<int, mixed[]> $actions
     */
    public function __construct(string $name, array $actions)
    {
        $this->name = $name;
        $this->actions = $actions;
    }

    /**
     * @return array<int, mixed[]>
     */
    public function getActions(): array
    {
        return $this->actions;
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
