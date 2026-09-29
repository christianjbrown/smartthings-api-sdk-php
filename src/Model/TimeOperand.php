<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class TimeOperand implements TimeOperandInterface
{
    /**
     * @var null|array<int, string>
     */
    private ?array $daysOfWeek = null;
    private ?IntervalInterface $offset = null;
    private string $reference;
    private ?string $timeZoneId = null;

    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return null|array<int, string>
     */
    public function getDaysOfWeek(): ?array
    {
        return $this->daysOfWeek;
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

    /**
     * @param null|array<int, string> $value
     */
    public function setDaysOfWeek(?array $value): TimeOperandInterface
    {
        $this->daysOfWeek = $value;

        return $this;
    }

    public function setOffset(?IntervalInterface $value): TimeOperandInterface
    {
        $this->offset = $value;

        return $this;
    }

    public function setTimeZoneId(?string $value): TimeOperandInterface
    {
        $this->timeZoneId = $value;

        return $this;
    }
}
