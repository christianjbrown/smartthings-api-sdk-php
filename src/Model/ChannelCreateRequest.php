<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class ChannelCreateRequest implements ChannelCreateRequestInterface
{
    private ?string $description = null;
    private ?string $name = null;
    private ?string $termsOfServiceUrl = null;
    private ?string $type = null;

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

    public function setDescription(?string $value): ChannelCreateRequestInterface
    {
        $this->description = $value;

        return $this;
    }

    public function setName(?string $value): ChannelCreateRequestInterface
    {
        $this->name = $value;

        return $this;
    }

    public function setTermsOfServiceUrl(?string $value): ChannelCreateRequestInterface
    {
        $this->termsOfServiceUrl = $value;

        return $this;
    }

    public function setType(?string $value): ChannelCreateRequestInterface
    {
        $this->type = $value;

        return $this;
    }
}
