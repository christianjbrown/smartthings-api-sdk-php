<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface SchemaAppInviteReceiptInterface
{
    public function getInvitationId(): ?string;

    public function getShortCode(): ?string;

    public function setInvitationId(?string $value): self;

    public function setShortCode(?string $value): self;
}
