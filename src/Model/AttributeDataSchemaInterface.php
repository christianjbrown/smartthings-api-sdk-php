<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeDataSchemaInterface
{
    public function getAdditionalProperties(): ?bool;

    /**
     * @return null|mixed[]
     */
    public function getProperties(): ?array;

    /**
     * @return null|array<int, string>
     */
    public function getRequired(): ?array;

    public function getType(): string;

    public function setAdditionalProperties(?bool $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setProperties(?array $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setRequired(?array $value): self;
}
