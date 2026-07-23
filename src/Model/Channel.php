<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class Channel implements ChannelInterface
{
    private string $channelId;
    private ?string $description = null;
    private ?string $name = null;
    private ?string $termsOfServiceUrl = null;
    private ?string $type = null;

    public function __construct(string $channelId)
    {
        $this->channelId = $channelId;
    }

    public function getChannelId(): string
    {
        return $this->channelId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getTermsOfServiceUrl(): ?string
    {
        return $this->termsOfServiceUrl;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setChannelId(string $value): ChannelInterface
    {
        $this->channelId = $value;

        return $this;
    }

    public function setDescription(?string $value): ChannelInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setName(?string $value): ChannelInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setTermsOfServiceUrl(?string $value): ChannelInterface
    {
        $this->termsOfServiceUrl = $value;

        return $this;
    }

    public function setType(?string $value): ChannelInterface
    {
        $this->type = $value;

        return $this;
    }
}
