<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface WebhookSmartAppInterface
{
    public function getPublicKey(): ?string;

    public function getSignatureType(): ?string;

    public function getTargetStatus(): ?string;

    public function getTargetUrl(): ?string;

    public function setPublicKey(?string $value): self;

    public function setSignatureType(?string $value): self;

    public function setTargetStatus(?string $value): self;

    public function setTargetUrl(?string $value): self;
}
