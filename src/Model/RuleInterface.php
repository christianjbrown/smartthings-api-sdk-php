<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface RuleInterface
{
    /**
     * @return array<int, ActionInterface>
     */
    public function getActions(): array;

    public function getAllowed(): ?string;

    public function getCreator(): ?string;

    public function getDateCreated(): ?string;

    public function getDateUpdated(): ?string;

    public function getExecutionLocation(): ?string;

    public function getId(): string;

    public function getName(): ?string;

    public function getOwnerId(): ?string;

    public function getOwnerType(): ?string;

    public function getSequence(): ?ActionSequenceInterface;

    public function getStatus(): ?string;

    public function getTimeZoneId(): ?string;

    /**
     * @param array<int, ActionInterface> $value
     */
    public function setActions(array $value): self;

    public function setAllowed(?string $value): self;

    public function setCreator(?string $value): self;

    public function setDateCreated(?string $value): self;

    public function setDateUpdated(?string $value): self;

    public function setExecutionLocation(?string $value): self;

    public function setId(string $value): self;

    public function setName(?string $value): self;

    public function setOwnerId(?string $value): self;

    public function setOwnerType(?string $value): self;

    public function setSequence(?ActionSequenceInterface $value): self;

    public function setStatus(?string $value): self;

    public function setTimeZoneId(?string $value): self;
}
