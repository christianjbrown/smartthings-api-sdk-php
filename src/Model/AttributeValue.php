<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeValue implements AttributeValueInterface
{
    private ?string $attribute = null;
    private ?string $inputType = null;

    /**
     * @var null|mixed[]
     */
    private ?array $staticValue = null;

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getInputType(): ?string
    {
        return $this->inputType;
    }

    /**
     * @return null|mixed[]
     */
    public function getStaticValue(): ?array
    {
        return $this->staticValue;
    }

    public function setAttribute(?string $value): AttributeValueInterface
    {
        $this->attribute = $value;

        return $this;
    }

    public function setInputType(?string $value): AttributeValueInterface
    {
        $this->inputType = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setStaticValue(?array $value): AttributeValueInterface
    {
        $this->staticValue = $value;

        return $this;
    }
}
