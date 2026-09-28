<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateInstalledAppEventsRequestInterface
{
    /**
     * @return null|array<int, SmartAppDashboardCardEventRequestInterface>
     */
    public function getSmartAppDashboardCardEvents(): ?array;

    /**
     * @return null|array<int, SmartAppEventRequestInterface>
     */
    public function getSmartAppEvents(): ?array;

    /**
     * @param null|array<int, SmartAppDashboardCardEventRequestInterface> $value
     */
    public function setSmartAppDashboardCardEvents(?array $value): self;

    /**
     * @param null|array<int, SmartAppEventRequestInterface> $value
     */
    public function setSmartAppEvents(?array $value): self;
}
