<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DateTimeOperandInterface
{
    public function getDay(): ?int;

    /**
     * @return null|array<int, string>
     */
    public function getDaysOfWeek(): ?array;

    public function getLocationId(): ?string;

    public function getMonth(): ?int;

    public function getOffset(): ?IntervalInterface;

    public function getReference(): string;

    public function getTimeZoneId(): ?string;

    public function getYear(): ?int;

    public function setDay(?int $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): self;

    public function setLocationId(?string $value): self;

    public function setMonth(?int $value): self;

    public function setOffset(?IntervalInterface $value): self;

    public function setTimeZoneId(?string $value): self;

    public function setYear(?int $value): self;
}
