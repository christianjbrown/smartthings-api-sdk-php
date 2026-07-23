<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Rule implements RuleInterface
{
    private string $id;
    private ?string $name = null;
    private ?string $status = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setId(string $value): RuleInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setName(?string $value): RuleInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setStatus(?string $value): RuleInterface
    {
        $this->status = $value;

        return $this;
    }
}
