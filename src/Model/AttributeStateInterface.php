<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface AttributeStateInterface
{
    /**
     * @return null|mixed[]
     */
    public function getData(): ?array;

    public function getTimestamp(): ?string;

    public function getUnit(): ?string;

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array;

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): self;

    public function setTimestamp(?string $value): self;

    public function setUnit(?string $value): self;

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): self;
}
