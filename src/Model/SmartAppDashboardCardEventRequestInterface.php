<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SmartAppDashboardCardEventRequestInterface
{
    public function getCardId(): string;

    public function getLifecycle(): string;
}
