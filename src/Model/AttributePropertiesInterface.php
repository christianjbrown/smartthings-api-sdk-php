<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributePropertiesInterface
{
    public function getData(): ?AttributeDataSchemaInterface;

    public function getUnit(): ?AttributeUnitSchemaInterface;

    public function getValue(): ?AttributeValueSchemaInterface;

    public function setData(?AttributeDataSchemaInterface $value): self;

    public function setUnit(?AttributeUnitSchemaInterface $value): self;
}
