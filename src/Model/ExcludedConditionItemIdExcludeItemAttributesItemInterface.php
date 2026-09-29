<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedConditionItemIdExcludeItemAttributesItemInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getExcludedValues(): ?array;

    public function getName(): string;

    /**
     * @param null|array<int, string> $value
     */
    public function setExcludedValues(?array $value): self;
}
