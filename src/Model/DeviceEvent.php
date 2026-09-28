<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DeviceEvent implements DeviceEventInterface
{
    private ?string $attribute = null;
    private ?string $capability = null;
    private ?string $commandId = null;
    private ?string $component = null;

    /**
     * @var null|mixed[]
     */
    private ?array $data = null;
    private ?string $unit = null;
    private mixed $value;

    public function __construct(mixed $value)
    {
        $this->value = $value;
    }

    public function getAttribute(): ?string
    {
        return $this->attribute;
    }

    public function getCapability(): ?string
    {
        return $this->capability;
    }

    public function getCommandId(): ?string
    {
        return $this->commandId;
    }

    public function getComponent(): ?string
    {
        return $this->component;
    }

    /**
     * @return null|mixed[]
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setAttribute(?string $value): DeviceEventInterface
    {
        $this->attribute = $value;

        return $this;
    }

    public function setCapability(?string $value): DeviceEventInterface
    {
        $this->capability = $value;

        return $this;
    }

    public function setCommandId(?string $value): DeviceEventInterface
    {
        $this->commandId = $value;

        return $this;
    }

    public function setComponent(?string $value): DeviceEventInterface
    {
        $this->component = $value;

        return $this;
    }

    /**
     * @param null|mixed[] $value
     */
    public function setData(?array $value): DeviceEventInterface
    {
        $this->data = $value;

        return $this;
    }

    public function setUnit(?string $value): DeviceEventInterface
    {
        $this->unit = $value;

        return $this;
    }
}
