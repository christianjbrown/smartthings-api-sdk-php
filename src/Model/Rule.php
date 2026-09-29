<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Rule implements RuleInterface
{
    /**
     * @var array<int, ActionInterface>
     */
    private array $actions = [];
    private ?string $allowed = null;
    private ?string $creator = null;
    private ?string $dateCreated = null;
    private ?string $dateUpdated = null;
    private ?string $executionLocation = null;
    private string $id;
    private ?string $name = null;
    private ?string $ownerId = null;
    private ?string $ownerType = null;
    private ?ActionSequenceInterface $sequence = null;
    private ?string $status = null;
    private ?string $timeZoneId = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    public function getAllowed(): ?string
    {
        return $this->allowed;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function getDateCreated(): ?string
    {
        return $this->dateCreated;
    }

    public function getDateUpdated(): ?string
    {
        return $this->dateUpdated;
    }

    public function getExecutionLocation(): ?string
    {
        return $this->executionLocation;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getOwnerId(): ?string
    {
        return $this->ownerId;
    }

    public function getOwnerType(): ?string
    {
        return $this->ownerType;
    }

    public function getSequence(): ?ActionSequenceInterface
    {
        return $this->sequence;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getTimeZoneId(): ?string
    {
        return $this->timeZoneId;
    }

    /**
     * @param array<int, ActionInterface> $value
     */
    public function setActions(array $value): RuleInterface
    {
        $this->actions = $value;

        return $this;
    }

    public function setAllowed(?string $value): RuleInterface
    {
        $this->allowed = $value;

        return $this;
    }

    public function setCreator(?string $value): RuleInterface
    {
        $this->creator = $value;

        return $this;
    }

    public function setDateCreated(?string $value): RuleInterface
    {
        $this->dateCreated = $value;

        return $this;
    }

    public function setDateUpdated(?string $value): RuleInterface
    {
        $this->dateUpdated = $value;

        return $this;
    }

    public function setExecutionLocation(?string $value): RuleInterface
    {
        $this->executionLocation = $value;

        return $this;
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

    public function setOwnerId(?string $value): RuleInterface
    {
        $this->ownerId = $value;

        return $this;
    }

    public function setOwnerType(?string $value): RuleInterface
    {
        $this->ownerType = $value;

        return $this;
    }

    public function setSequence(?ActionSequenceInterface $value): RuleInterface
    {
        $this->sequence = $value;

        return $this;
    }

    public function setStatus(?string $value): RuleInterface
    {
        $this->status = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): RuleInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
