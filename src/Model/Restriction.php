<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Restriction implements RestrictionInterface
{
    private ?int $historyRetentionTTLDays = null;
    private int $tier;
    private ?bool $visibleWhenRestricted = null;

    public function __construct(int $tier)
    {
        $this->tier = $tier;
    }

    public function getHistoryRetentionTTLDays(): ?int
    {
        return $this->historyRetentionTTLDays;
    }

    public function getTier(): int
    {
        return $this->tier;
    }

    public function getVisibleWhenRestricted(): ?bool
    {
        return $this->visibleWhenRestricted;
    }

    public function setHistoryRetentionTTLDays(?int $value): RestrictionInterface
    {
        $this->historyRetentionTTLDays = $value;

        return $this;
    }

    public function setVisibleWhenRestricted(?bool $value): RestrictionInterface
    {
        $this->visibleWhenRestricted = $value;

        return $this;
    }
}
