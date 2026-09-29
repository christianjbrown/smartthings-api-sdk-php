<?php

declare(strict_types=1);

namespace ChristianBrown\SmartThings\Model;

interface ServiceSubscriptionRequestInterface
{
    /**
     * @return array<int, string>
     */
    public function getCapabilities(): array;

    public function getIsaId(): string;

    public function getPostalCode(): ?string;

    public function getPredicate(): ?string;

    public function getType(): ?string;

    public function setPostalCode(?string $value): self;

    public function setPredicate(?string $value): self;

    public function setType(?string $value): self;
}
