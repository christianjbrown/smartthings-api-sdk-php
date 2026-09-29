<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface PatchItemInterface
{
    public function getOp(): string;

    public function getPath(): string;

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array;

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): self;
}
