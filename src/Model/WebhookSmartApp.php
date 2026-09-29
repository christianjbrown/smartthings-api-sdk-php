<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

final class WebhookSmartApp implements WebhookSmartAppInterface
{
    private ?string $publicKey = null;
    private ?string $signatureType = null;
    private ?string $targetStatus = null;
    private ?string $targetUrl = null;

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    public function getSignatureType(): ?string
    {
        return $this->signatureType;
    }

    public function getTargetStatus(): ?string
    {
        return $this->targetStatus;
    }

    public function getTargetUrl(): ?string
    {
        return $this->targetUrl;
    }

    public function setPublicKey(?string $value): WebhookSmartAppInterface
    {
        $this->publicKey = $value;

        return $this;
    }

    public function setSignatureType(?string $value): WebhookSmartAppInterface
    {
        $this->signatureType = $value;

        return $this;
    }

    public function setTargetStatus(?string $value): WebhookSmartAppInterface
    {
        $this->targetStatus = $value;

        return $this;
    }

    public function setTargetUrl(?string $value): WebhookSmartAppInterface
    {
        $this->targetUrl = $value;

        return $this;
    }
}
