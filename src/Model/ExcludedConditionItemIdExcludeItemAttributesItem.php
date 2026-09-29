<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedConditionItemIdExcludeItemAttributesItem implements ExcludedConditionItemIdExcludeItemAttributesItemInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $excludedValues = null;
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return null|array<int, string>
     */
    public function getExcludedValues(): ?array
    {
        return $this->excludedValues;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setExcludedValues(?array $value): ExcludedConditionItemIdExcludeItemAttributesItemInterface
    {
        $this->excludedValues = $value;

        return $this;
    }
}
