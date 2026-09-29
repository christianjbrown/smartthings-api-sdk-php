<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedConditionItemIdExcludeItemInterface
{
    /**
     * @return null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface>
     */
    public function getAttributes(): ?array;

    public function getCapability(): string;

    public function getComponent(): ?string;

    public function getVersion(): ?int;

    /**
     * @param null|array<int, ExcludedConditionItemIdExcludeItemAttributesItemInterface> $value
     */
    public function setAttributes(?array $value): self;

    public function setComponent(?string $value): self;

    public function setVersion(?int $value): self;
}
