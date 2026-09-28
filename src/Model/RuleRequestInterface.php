<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

/**
 * A Rule's actions follow the vendor's recursive Action/Condition expression
 * language (if/sleep/command/scene/every/location/limit/toggle, each of which can
 * itself nest further actions and conditions). Modeling every variant as its own
 * typed class would add dozens of classes out of proportion with the rest of this
 * SDK, so actions are accepted here as raw arrays shaped per the vendor's Action
 * schema (https://developer.smartthings.com/docs/api/public/#operation/createRule)
 * and passed through to the API unmodified.
 */
interface RuleRequestInterface
{
    /**
     * @return array<int, mixed[]>
     */
    public function getActions(): array;

    public function getName(): string;

    public function getSequence(): ?string;

    public function getTimeZoneId(): ?string;

    public function setSequence(?string $value): self;

    public function setTimeZoneId(?string $value): self;
}
