<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ExcludedActionItemInterface
{
    /**
     * @return array<int, ExcludedActionItemIdExcludeItemInterface>
     */
    public function getExclude(): array;

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array;

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): self;
}
