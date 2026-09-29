<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedConditionItemIdInterface
{
    /**
     * @return array<int, ExcludedConditionItemIdExcludeItemInterface>
     */
    public function getExclude(): array;

    public function getId(): ?int;

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array;

    public function setId(?int $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): self;
}
