<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SmartAppDashboardCardEventRequest implements SmartAppDashboardCardEventRequestInterface
{
    private string $cardId;
    private string $lifecycle;

    public function __construct(string $cardId, string $lifecycle)
    {
        $this->cardId = $cardId;
        $this->lifecycle = $lifecycle;
    }

    public function getCardId(): string
    {
        return $this->cardId;
    }

    public function getLifecycle(): string
    {
        return $this->lifecycle;
    }
}
