<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeSchema implements AttributeSchemaInterface
{
    private ?bool $additionalProperties = null;
    private ?AttributePropertiesInterface $properties;

    /**
     * @var null|array<int, string>
     */
    private ?array $required = null;
    private ?bool $sensitive = null;
    private ?string $title = null;
    private ?string $type = null;

    public function __construct(?AttributePropertiesInterface $properties)
    {
        $this->properties = $properties;
    }

    public function getAdditionalProperties(): ?bool
    {
        return $this->additionalProperties;
    }

    public function getProperties(): ?AttributePropertiesInterface
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

    public function getSensitive(): ?bool
    {
        return $this->sensitive;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setAdditionalProperties(?bool $value): AttributeSchemaInterface
    {
        $this->additionalProperties = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setRequired(?array $value): AttributeSchemaInterface
    {
        $this->required = $value;

        return $this;
    }

    public function setSensitive(?bool $value): AttributeSchemaInterface
    {
        $this->sensitive = $value;

        return $this;
    }

    public function setTitle(?string $value): AttributeSchemaInterface
    {
        $this->title = $value;

        return $this;
    }

    public function setType(?string $value): AttributeSchemaInterface
    {
        $this->type = $value;

        return $this;
    }
}
