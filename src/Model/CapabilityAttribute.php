<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CapabilityAttribute implements CapabilityAttributeInterface
{
    /**
     * @var null|array<int, EnumCommandInterface>
     */
    private ?array $enumCommands = null;
    private ?AttributeSchemaInterface $schema = null;
    private ?string $setter = null;

    /**
     * @return null|array<int, EnumCommandInterface>
     */
    public function getEnumCommands(): ?array
    {
        return $this->enumCommands;
    }

    public function getSchema(): ?AttributeSchemaInterface
    {
        return $this->schema;
    }

    public function getSetter(): ?string
    {
        return $this->setter;
    }

    /**
     * @param null|array<int, EnumCommandInterface> $value
     */
    public function setEnumCommands(?array $value): CapabilityAttributeInterface
    {
        $this->enumCommands = $value;

        return $this;
    }

    public function setSchema(?AttributeSchemaInterface $value): CapabilityAttributeInterface
    {
        $this->schema = $value;

        return $this;
    }

    public function setSetter(?string $value): CapabilityAttributeInterface
    {
        $this->setter = $value;

        return $this;
    }
}
