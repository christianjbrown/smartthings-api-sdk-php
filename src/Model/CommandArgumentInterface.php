<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CommandArgumentInterface
{
    public function getName(): string;

    public function getOptional(): ?bool;

    /**
     * @return mixed[]
     */
    public function getSchema(): array;

    public function setOptional(?bool $value): self;
}
