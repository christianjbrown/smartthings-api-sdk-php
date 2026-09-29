<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class AttributeState implements AttributeStateInterface
{
    /**
     * @var null|mixed[]
     */
    private ?array $data = null;
    private ?string $timestamp = null;
    private ?string $unit = null;

    /**
     * @var null|mixed[]
     */
    private ?array $value = null;

    /**
     * @return null|mixed[]
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @return null|mixed[]
     */
    public function getValue(): ?array
    {
        return $this->value;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): AttributeStateInterface
    {
        $this->data = $value;

        return $this;
    }

    public function setTimestamp(?string $value): AttributeStateInterface
    {
        $this->timestamp = $value;

        return $this;
    }

    public function setUnit(?string $value): AttributeStateInterface
    {
        $this->unit = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setValue(?array $value): AttributeStateInterface
    {
        $this->value = $value;

        return $this;
    }
}
