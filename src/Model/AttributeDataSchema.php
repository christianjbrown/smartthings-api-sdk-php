<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeDataSchema implements AttributeDataSchemaInterface
{
    private ?bool $additionalProperties = null;

    /**
     * @var null|mixed[]
     */
    private ?array $properties = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $required = null;
    private ?string $type;

    public function __construct(?string $type)
    {
        $this->type = $type;
    }

    public function getAdditionalProperties(): ?bool
    {
        return $this->additionalProperties;
    }

    /**
     * @return null|mixed[]
     */
    public function getProperties(): ?array
    {
        return $this->properties;
    }

    /**
     * @return null|array<int, string>
     */
    public function getRequired(): ?array
    {
        return $this->required;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setAdditionalProperties(?bool $value): AttributeDataSchemaInterface
    {
        $this->additionalProperties = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setProperties(?array $value): AttributeDataSchemaInterface
    {
        $this->properties = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setRequired(?array $value): AttributeDataSchemaInterface
    {
        $this->required = $value;

        return $this;
    }
}
