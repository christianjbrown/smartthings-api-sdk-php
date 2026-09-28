<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class GenerateAppOauthResponse implements GenerateAppOauthResponseInterface
{
    private ?AppOauthInterface $oauthClientDetails = null;
    private ?string $oauthClientId = null;
    private ?string $oauthClientSecret = null;

    public function getOauthClientDetails(): ?AppOauthInterface
    {
        return $this->oauthClientDetails;
    }

    public function getOauthClientId(): ?string
    {
        return $this->oauthClientId;
    }

    public function getOauthClientSecret(): ?string
    {
        return $this->oauthClientSecret;
    }

    public function setOauthClientDetails(?AppOauthInterface $value): GenerateAppOauthResponseInterface
    {
        $this->oauthClientDetails = $value;

        return $this;
    }

    public function setOauthClientId(?string $value): GenerateAppOauthResponseInterface
    {
        $this->oauthClientId = $value;

        return $this;
    }

    public function setOauthClientSecret(?string $value): GenerateAppOauthResponseInterface
    {
        $this->oauthClientSecret = $value;

        return $this;
    }
}
