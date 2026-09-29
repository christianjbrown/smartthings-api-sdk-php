<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeUnitSchemaInterface
{
    public function getDefault(): ?string;

    /**
     * @return null|array<int, string>
     */
    public function getEnum(): ?array;

    public function getType(): ?string;

    public function setDefault(?string $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setEnum(?array $value): self;

    public function setType(?string $value): self;
}
