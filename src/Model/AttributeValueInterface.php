<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeValueInterface
{
    public function getAttribute(): ?string;

    public function getInputType(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getStaticValue(): ?array;

    public function setAttribute(?string $value): self;

    public function setInputType(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setStaticValue(?array $value): self;
}
