<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeSchemaInterface
{
    public function getAdditionalProperties(): ?bool;

    public function getProperties(): ?AttributePropertiesInterface;

    /**
     * @return null|array<int, string>
     */
    public function getRequired(): ?array;

    public function getSensitive(): ?bool;

    public function getTitle(): ?string;

    public function getType(): ?string;

    public function setAdditionalProperties(?bool $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setRequired(?array $value): self;

    public function setSensitive(?bool $value): self;

    public function setTitle(?string $value): self;

    public function setType(?string $value): self;
}
