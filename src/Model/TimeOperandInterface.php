<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface TimeOperandInterface
{
    /**
     * @return null|array<int, string>
     */
    public function getDaysOfWeek(): ?array;

    public function getOffset(): ?IntervalInterface;

    public function getReference(): string;

    public function getTimeZoneId(): ?string;

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): self;

    public function setOffset(?IntervalInterface $value): self;

    public function setTimeZoneId(?string $value): self;
}
