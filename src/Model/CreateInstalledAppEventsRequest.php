<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateInstalledAppEventsRequest implements CreateInstalledAppEventsRequestInterface
{
    /**
     * @var null|array<int, SmartAppDashboardCardEventRequestInterface>
     */
    private ?array $smartAppDashboardCardEvents = null;

    /**
     * @var null|array<int, SmartAppEventRequestInterface>
     */
    private ?array $smartAppEvents = null;

    /**
     * @return null|array<int, SmartAppDashboardCardEventRequestInterface>
     */
    public function getSmartAppDashboardCardEvents(): ?array
    {
        return $this->smartAppDashboardCardEvents;
    }

    /**
     * @return null|array<int, SmartAppEventRequestInterface>
     */
    public function getSmartAppEvents(): ?array
    {
        return $this->smartAppEvents;
    }

    /**
     * @param null|array<int, SmartAppDashboardCardEventRequestInterface> $value
     */
    public function setSmartAppDashboardCardEvents(?array $value): CreateInstalledAppEventsRequestInterface
    {
        $this->smartAppDashboardCardEvents = $value;

        return $this;
    }

    /**
     * @param null|array<int, SmartAppEventRequestInterface> $value
     */
    public function setSmartAppEvents(?array $value): CreateInstalledAppEventsRequestInterface
    {
        $this->smartAppEvents = $value;

        return $this;
    }
}
