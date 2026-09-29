<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedConditionItemId implements ExcludedConditionItemIdInterface
{
    /**
     * @var array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    private array $exclude;
    private ?int $id = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setId(?int $value): ExcludedConditionItemIdInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): ExcludedConditionItemIdInterface
    {
        $this->value = $value;

        return $this;
    }
}
