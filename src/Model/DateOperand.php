<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DateOperand implements DateOperandInterface
{
    private ?int $day = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $daysOfWeek = null;
    private ?int $month = null;
    private ?string $reference = null;
    private ?string $timeZoneId = null;
    private ?int $year = null;

    public function getDay(): ?int
    {
        return $this->day;
    }

    /**
     * @return null|array<int, string>
     */
    public function getDaysOfWeek(): ?array
    {
        return $this->daysOfWeek;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getTimeZoneId(): ?string
    {
        return $this->timeZoneId;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setDay(?int $value): DateOperandInterface
    {
        $this->day = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): DateOperandInterface
    {
        $this->daysOfWeek = $value;

        return $this;
    }

    public function setMonth(?int $value): DateOperandInterface
    {
        $this->month = $value;

        return $this;
    }

    public function setReference(?string $value): DateOperandInterface
    {
        $this->reference = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): DateOperandInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }

    public function setYear(?int $value): DateOperandInterface
    {
        $this->year = $value;

        return $this;
    }
}
