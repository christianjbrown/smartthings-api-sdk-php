<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class HubEnrolledChannel implements HubEnrolledChannelInterface
{
    private string $channelId;
    private ?string $createdDate = null;
    private ?string $description = null;
    private ?bool $isWWST = null;
    private ?string $lastModifiedDate = null;
    private ?string $name = null;
    private ?string $subscriptionUrl = null;

    public function __construct(string $channelId)
    {
        $this->channelId = $channelId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getCreatedDate(): ?string
    {
        return $this->createdDate;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIsWWST(): ?bool
    {
        return $this->isWWST;
    }

    public function getLastModifiedDate(): ?string
    {
        return $this->lastModifiedDate;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSubscriptionUrl(): ?string
    {
        return $this->subscriptionUrl;
    }

    public function setChannelId(string $value): HubEnrolledChannelInterface
    {
        $this->channelId = $value;

        return $this;
    }

    public function setCreatedDate(?string $value): HubEnrolledChannelInterface
    {
        $this->createdDate = $value;

        return $this;
    }

    public function setDescription(?string $value): HubEnrolledChannelInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setIsWWST(?bool $value): HubEnrolledChannelInterface
    {
        $this->isWWST = $value;

        return $this;
    }

    public function setLastModifiedDate(?string $value): HubEnrolledChannelInterface
    {
        $this->lastModifiedDate = $value;

        return $this;
    }

    public function setName(?string $value): HubEnrolledChannelInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setSubscriptionUrl(?string $value): HubEnrolledChannelInterface
    {
        $this->subscriptionUrl = $value;

        return $this;
    }
}
