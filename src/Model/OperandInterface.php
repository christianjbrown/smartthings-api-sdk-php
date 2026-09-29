<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface OperandInterface
{
    public function getArray(): ?ArrayOperandInterface;

    public function getBoolean(): ?bool;

    public function getDate(): ?DateOperandInterface;

    public function getDatetime(): ?DateTimeOperandInterface;

    public function getDecimal(): ?float;

    public function getDevice(): ?DeviceOperandInterface;

    public function getInteger(): ?int;

    public function getLocation(): ?LocationOperandInterface;

    /**
     * @return null|array<array-key, OperandInterface>
     */
    public function getMap(): ?array;

    public function getString(): ?string;

    public function getTime(): ?TimeOperandInterface;

    public function setArray(?ArrayOperandInterface $value): self;

    public function setBoolean(?bool $value): self;

    public function setDate(?DateOperandInterface $value): self;

    public function setDatetime(?DateTimeOperandInterface $value): self;

    public function setDecimal(?float $value): self;

    public function setDevice(?DeviceOperandInterface $value): self;

    public function setInteger(?int $value): self;

    public function setLocation(?LocationOperandInterface $value): self;

    /**
     * @param null|array<array-key, OperandInterface> $value
     */
    public function setMap(?array $value): self;

    public function setString(?string $value): self;

    public function setTime(?TimeOperandInterface $value): self;
}
