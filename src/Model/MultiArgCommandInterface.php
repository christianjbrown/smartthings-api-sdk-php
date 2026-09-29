<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface MultiArgCommandInterface
{
    /**
     * @return array<int, MultiArgCommandArgumentsItemInterface>
     */
    public function getArguments(): array;

    public function getCommand(): string;

    public function getSupportedValues(): ?string;

    public function setSupportedValues(?string $value): self;
}
