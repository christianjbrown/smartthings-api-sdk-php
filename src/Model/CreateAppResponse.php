<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class CreateAppResponse implements CreateAppResponseInterface
{
    private ?AppInterface $app = null;
    private ?string $oauthClientId = null;
    private ?string $oauthClientSecret = null;

    public function getApp(): ?AppInterface
    {
        return $this->app;
    }

    public function getOauthClientId(): ?string
    {
        return $this->oauthClientId;
    }

    public function getOauthClientSecret(): ?string
    {
        return $this->oauthClientSecret;
    }

    public function setApp(?AppInterface $value): CreateAppResponseInterface
    {
        $this->app = $value;

        return $this;
    }

    public function setOauthClientId(?string $value): CreateAppResponseInterface
    {
        $this->oauthClientId = $value;

        return $this;
    }

    public function setOauthClientSecret(?string $value): CreateAppResponseInterface
    {
        $this->oauthClientSecret = $value;

        return $this;
    }
}
