<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInviteStatusInterface
{
    public function getDescription(): ?string;

    public function getExpiration(): ?float;

    public function getIsAccepted(): ?bool;

    public function getSchemaAppId(): ?string;

    public function getShortCode(): ?string;

    public function setDescription(?string $value): self;

    public function setExpiration(?float $value): self;

    public function setIsAccepted(?bool $value): self;

    public function setSchemaAppId(?string $value): self;

    public function setShortCode(?string $value): self;
}
