<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Subscription implements SubscriptionInterface
{
    private string $id;
    private ?string $installedAppId = null;
    private ?string $sourceType = null;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getInstalledAppId(): ?string
    {
        return $this->installedAppId;
    }

    public function getSourceType(): ?string
    {
        return $this->sourceType;
    }

    public function setId(string $value): SubscriptionInterface
    {
        $this->id = $value;

        return $this;
    }

    public function setInstalledAppId(?string $value): SubscriptionInterface
    {
        $this->installedAppId = $value;

        return $this;
    }

    public function setSourceType(?string $value): SubscriptionInterface
    {
        $this->sourceType = $value;

        return $this;
    }
}
