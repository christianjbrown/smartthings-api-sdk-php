<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedActionItemIdExcludeItemInterface
{
    public function getCapability(): string;

    /**
     * @return null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    public function getCommands(): ?array;

    public function getComponent(): ?string;

    public function getVersion(): ?int;

    /**
     * @param null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface> $value
     */
    public function setCommands(?array $value): self;

    public function setComponent(?string $value): self;

    public function setVersion(?int $value): self;
}
