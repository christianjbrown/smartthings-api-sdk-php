<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class SchemaAppInviteReceipt implements SchemaAppInviteReceiptInterface
{
    private ?string $invitationId = null;
    private ?string $shortCode = null;

    public function getInvitationId(): ?string
    {
        return $this->invitationId;
    }

    public function getShortCode(): ?string
    {
        return $this->shortCode;
    }

    public function setInvitationId(?string $value): SchemaAppInviteReceiptInterface
    {
        $this->invitationId = $value;

        return $this;
    }

    public function setShortCode(?string $value): SchemaAppInviteReceiptInterface
    {
        $this->shortCode = $value;

        return $this;
    }
}
