<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedActionItem implements ExcludedActionItemInterface
{
    /**
     * @var array<int, ExcludedActionItemIdExcludeItemInterface>
     */
    private array $exclude;

    /**
     * @var null|mixed[]
     */
    private ?array $value = null;

    /**
     * @phpstan-param array<int, ExcludedActionItemIdExcludeItemInterface> $exclude
     */
    public function __construct(array $exclude)
    {
        $this->exclude = $exclude;
    }

    /**
     * @return array<int, ExcludedActionItemIdExcludeItemInterface>
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
    public function setValue(?array $value): ExcludedActionItemInterface
    {
        $this->value = $value;

        return $this;
    }
}
