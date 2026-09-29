<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class DateTimeOperand implements DateTimeOperandInterface
{
    private ?int $day = null;

    /**
     * @var null|array<int, string>
     */
    private ?array $daysOfWeek = null;
    private ?string $locationId = null;
    private ?int $month = null;
    private ?IntervalInterface $offset = null;
    private string $reference;
    private ?string $timeZoneId = null;
    private ?int $year = null;

    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }

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

    public function getLocationId(): ?string
    {
        return $this->locationId;
    }

    public function getMonth(): ?int
    {
        return $this->month;
    }

    public function getOffset(): ?IntervalInterface
    {
        return $this->offset;
    }

    public function getReference(): string
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

    public function setDay(?int $value): DateTimeOperandInterface
    {
        $this->day = $value;

        return $this;
    }

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): DateTimeOperandInterface
    {
        $this->daysOfWeek = $value;

        return $this;
    }

    public function setLocationId(?string $value): DateTimeOperandInterface
    {
        $this->locationId = $value;

        return $this;
    }

    public function setMonth(?int $value): DateTimeOperandInterface
    {
        $this->month = $value;

        return $this;
    }

    public function setOffset(?IntervalInterface $value): DateTimeOperandInterface
    {
        $this->offset = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): DateTimeOperandInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }

    public function setYear(?int $value): DateTimeOperandInterface
    {
        $this->year = $value;

        return $this;
    }
}
