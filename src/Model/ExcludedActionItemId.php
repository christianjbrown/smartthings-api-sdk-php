<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ExcludedActionItemId implements ExcludedActionItemIdInterface
{
    /**
     * @var array<int, ExcludedActionItemIdExcludeItemInterface>
     */
    private array $exclude;
    private ?int $id = null;

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

    public function setId(?int $value): ExcludedActionItemIdInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): ExcludedActionItemIdInterface
    {
        $this->value = $value;

        return $this;
    }
}
