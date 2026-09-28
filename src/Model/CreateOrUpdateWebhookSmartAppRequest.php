<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateOrUpdateWebhookSmartAppRequest implements CreateOrUpdateWebhookSmartAppRequestInterface
{
    private string $targetUrl;

    public function __construct(string $targetUrl)
    {
        $this->targetUrl = $targetUrl;
    }

    public function getTargetUrl(): string
    {
        return $this->targetUrl;
    }
}
