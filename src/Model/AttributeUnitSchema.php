<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeUnitSchema implements AttributeUnitSchemaInterface
{
    private ?string $default = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $enum = null;
    private ?string $type = null;

    public function getDefault(): ?string
    {
        return $this->default;
    }

    /**
     * @return null|array<int, string>
     */
    public function getEnum(): ?array
    {
        return $this->enum;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setDefault(?string $value): AttributeUnitSchemaInterface
    {
        $this->default = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setEnum(?array $value): AttributeUnitSchemaInterface
    {
        $this->enum = $value;

        return $this;
    }

    public function setType(?string $value): AttributeUnitSchemaInterface
    {
        $this->type = $value;

        return $this;
    }
}
