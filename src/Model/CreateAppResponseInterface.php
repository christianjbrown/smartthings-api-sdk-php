<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface CreateAppResponseInterface
{
    public function getApp(): ?AppInterface;

    public function getOauthClientId(): ?string;

    public function getOauthClientSecret(): ?string;

    public function setApp(?AppInterface $value): self;

    public function setOauthClientId(?string $value): self;

    public function setOauthClientSecret(?string $value): self;
}
