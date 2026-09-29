<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Operand implements OperandInterface
{
    private ?ArrayOperandInterface $array = null;
    private ?bool $boolean = null;
    private ?DateOperandInterface $date = null;
    private ?DateTimeOperandInterface $datetime = null;
    private ?float $decimal = null;
    private ?DeviceOperandInterface $device = null;
    private ?int $integer = null;
    private ?LocationOperandInterface $location = null;

    /**
     * @var null|array<array-key, OperandInterface>
     */
    private ?array $map = null;
    private ?string $string = null;
    private ?TimeOperandInterface $time = null;

    public function getArray(): ?ArrayOperandInterface
    {
        return $this->array;
    }

    public function getBoolean(): ?bool
    {
        return $this->boolean;
    }

    public function getDate(): ?DateOperandInterface
    {
        return $this->date;
    }

    public function getDatetime(): ?DateTimeOperandInterface
    {
        return $this->datetime;
    }

    public function getDecimal(): ?float
    {
        return $this->decimal;
    }

    public function getDevice(): ?DeviceOperandInterface
    {
        return $this->device;
    }

    public function getInteger(): ?int
    {
        return $this->integer;
    }

    public function getLocation(): ?LocationOperandInterface
    {
        return $this->location;
    }

    /**
     * @return null|array<array-key, OperandInterface>
     */
    public function getMap(): ?array
    {
        return $this->map;
    }

    public function getString(): ?string
    {
        return $this->string;
    }

    public function getTime(): ?TimeOperandInterface
    {
        return $this->time;
    }

    public function setArray(?ArrayOperandInterface $value): OperandInterface
    {
        $this->array = $value;

        return $this;
    }

    public function setBoolean(?bool $value): OperandInterface
    {
        $this->boolean = $value;

        return $this;
    }

    public function setDate(?DateOperandInterface $value): OperandInterface
    {
        $this->date = $value;

        return $this;
    }

    public function setDatetime(?DateTimeOperandInterface $value): OperandInterface
    {
        $this->datetime = $value;

        return $this;
    }

    public function setDecimal(?float $value): OperandInterface
    {
        $this->decimal = $value;

        return $this;
    }

    public function setDevice(?DeviceOperandInterface $value): OperandInterface
    {
        $this->device = $value;

        return $this;
    }

    public function setInteger(?int $value): OperandInterface
    {
        $this->integer = $value;

        return $this;
    }

    public function setLocation(?LocationOperandInterface $value): OperandInterface
    {
        $this->location = $value;

        return $this;
    }

    /**
     * @param null|array<array-key, OperandInterface> $value
     */
    public function setMap(?array $value): OperandInterface
    {
        $this->map = $value;

        return $this;
    }

    public function setString(?string $value): OperandInterface
    {
        $this->string = $value;

        return $this;
    }

    public function setTime(?TimeOperandInterface $value): OperandInterface
    {
        $this->time = $value;

        return $this;
    }
}
