<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CapabilityAttributeInterface
{
    /**
     * @return null|array<int, EnumCommandInterface>
     */
    public function getEnumCommands(): ?array;

    public function getSchema(): ?AttributeSchemaInterface;

    public function getSetter(): ?string;

    /**
     * @param null|array<int, EnumCommandInterface> $value
     */
    public function setEnumCommands(?array $value): self;

    public function setSchema(?AttributeSchemaInterface $value): self;

    public function setSetter(?string $value): self;
}
