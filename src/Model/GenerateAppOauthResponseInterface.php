<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface GenerateAppOauthResponseInterface
{
    public function getOauthClientDetails(): ?AppOauthInterface;

    public function getOauthClientId(): ?string;

    public function getOauthClientSecret(): ?string;

    public function setOauthClientDetails(?AppOauthInterface $value): self;

    public function setOauthClientId(?string $value): self;

    public function setOauthClientSecret(?string $value): self;
}
