<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * A Rule's actions follow the vendor's recursive Action/Condition expression language. Each
 * entry is either a typed ActionInterface (see the Action model tree) or a raw array shaped per
 * the vendor's Action schema (https://developer.smartthings.com/docs/api/public/#operation/createRule),
 * which is passed through to the API unmodified. Both kinds can be mixed in one list.
 */
interface RuleRequestInterface
{
    /**
     * @return array<int, ActionInterface|mixed[]>
     */
    public function getActions(): array;

    /**
     * The typed form of the rule's sequence; it takes precedence over getSequence() when set.
     */
    public function getActionSequence(): ?ActionSequenceInterface;

    public function getName(): string;

    public function getSequence(): ?string;

    public function getTimeZoneId(): ?string;

    public function setActionSequence(?ActionSequenceInterface $value): self;

    public function setSequence(?string $value): self;

    public function setTimeZoneId(?string $value): self;
}
