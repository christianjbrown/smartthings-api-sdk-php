<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateOrUpdateWebhookSmartAppRequestInterface
{
    public function getTargetUrl(): string;
}
