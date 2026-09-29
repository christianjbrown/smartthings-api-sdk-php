<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ChannelUpdateRequest implements ChannelUpdateRequestInterface
{
    private ?string $description = null;
    private ?string $name = null;
    private ?string $termsOfServiceUrl = null;

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

    public function setDescription(?string $value): ChannelUpdateRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setName(?string $value): ChannelUpdateRequestInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setTermsOfServiceUrl(?string $value): ChannelUpdateRequestInterface
    {
        $this->termsOfServiceUrl = $value;

        return $this;
    }
}
