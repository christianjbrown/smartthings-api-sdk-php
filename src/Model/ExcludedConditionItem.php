<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedConditionItem implements ExcludedConditionItemInterface
{
    /**
     * @var array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    private array $exclude;

    /**
     * @var null|mixed[]
     */
    private ?array $value = null;

    /**
     * @phpstan-param array<int, ExcludedConditionItemIdExcludeItemInterface> $exclude
     */
    public function __construct(array $exclude)
    {
        $this->exclude = $exclude;
    }

    /**
     * @return array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    public function getExclude(): array
    {
        return $this->exclude;
    }

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): ExcludedConditionItemInterface
    {
        $this->value = $value;

        return $this;
    }
}
