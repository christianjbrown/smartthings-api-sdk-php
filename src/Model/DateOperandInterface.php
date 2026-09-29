<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface DateOperandInterface
{
    public function getDay(): ?int;

    /**
     * @return null|array<int, string>
     */
    public function getDaysOfWeek(): ?array;

    public function getMonth(): ?int;

    public function getReference(): ?string;

    public function getTimeZoneId(): ?string;

    public function getYear(): ?int;

    public function setDay(?int $value): self;

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): self;

    public function setMonth(?int $value): self;

    public function setReference(?string $value): self;

    public function setTimeZoneId(?string $value): self;

    public function setYear(?int $value): self;
}
