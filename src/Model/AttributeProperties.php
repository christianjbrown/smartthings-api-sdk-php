<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeProperties implements AttributePropertiesInterface
{
    private ?AttributeDataSchemaInterface $data = null;
    private ?AttributeUnitSchemaInterface $unit = null;
    private AttributeValueSchemaInterface $value;

    public function __construct(AttributeValueSchemaInterface $value)
    {
        $this->value = $value;
    }

    public function getData(): ?AttributeDataSchemaInterface
    {
        return $this->data;
    }

    public function getUnit(): ?AttributeUnitSchemaInterface
    {
        return $this->unit;
    }

    public function getValue(): AttributeValueSchemaInterface
    {
        return $this->value;
    }

    public function setData(?AttributeDataSchemaInterface $value): AttributePropertiesInterface
    {
        $this->data = $value;

        return $this;
    }

    public function setUnit(?AttributeUnitSchemaInterface $value): AttributePropertiesInterface
    {
        $this->unit = $value;

        return $this;
    }
}
